<?php

namespace ColissimoPickupPoint\Loop;

use ColissimoPickupPoint\Model\ColissimoPickupPointDeliveryModeQuery;
use ColissimoPickupPoint\ColissimoPickupPoint;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;

class ColissimoPickupPointDeliveryMode extends BaseLoop implements PropelSearchLoopInterface
{
    /**
     * @return ArgumentCollection
     */
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntTypeArgument('id')
        );
    }

    public function buildModelCriteria()
    {
        $mode = $this->getId();

        $modes = ColissimoPickupPointDeliveryModeQuery::create();

        if (null !== $mode) {
            $modes->filterById($mode);
        }

        return $modes;
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var \ColissimoPickupPoint\Model\ColissimoPickupPointDeliveryMode $mode */
        foreach ($loopResult->getResultDataCollection() as $mode) {
            if (ColissimoPickupPoint::getConfigValue('socolissimo_dom_delivery_authorized') || $mode->getId() !== 1) {
                $loopResultRow = new LoopResultRow($mode);
                $loopResultRow
                    ->set("ID", $mode->getId())
                    ->set("TITLE", $mode->getTitle())
                    ->set("CODE", $mode->getCode())
                    ->set("FREESHIPPING_ACTIVE", $mode->getFreeshippingActive())
                    ->set("FREESHIPPING_FROM", $mode->getFreeshippingFrom());
                $loopResult->addRow($loopResultRow);
            }
        }
        return $loopResult;
    }

}