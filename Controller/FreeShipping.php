<?php
/*************************************************************************************/
/*                                                                                   */
/*      Thelia                                                                       */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : info@thelia.net                                                      */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      This program is free software; you can redistribute it and/or modify         */
/*      it under the terms of the GNU General Public License as published by         */
/*      the Free Software Foundation; either version 3 of the License                */
/*                                                                                   */
/*      This program is distributed in the hope that it will be useful,              */
/*      but WITHOUT ANY WARRANTY; without even the implied warranty of               */
/*      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the                */
/*      GNU General Public License for more details.                                 */
/*                                                                                   */
/*      You should have received a copy of the GNU General Public License            */
/*      along with this program. If not, see <http://www.gnu.org/licenses/>.         */
/*                                                                                   */
/*************************************************************************************/

namespace ColissimoPickupPoint\Controller;

use ColissimoPickupPoint\Model\ColissimoPickupPointAreaFreeshipping;
use ColissimoPickupPoint\Model\ColissimoPickupPointAreaFreeshippingQuery;
use ColissimoPickupPoint\Model\ColissimoPickupPointFreeshippingQuery;
use Propel\Runtime\Exception\PropelException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\HttpFoundation\Response;

use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Core\Security\AccessManager;
use Thelia\Model\AreaQuery;

class FreeShipping extends BaseAdminController
{
    public function toggleFreeShippingActivation()
    {
        if (null !== $response = $this
                ->checkAuth(array(AdminResources::MODULE), array('ColissimoPickupPoint'), AccessManager::UPDATE)) {
            return $response;
        }

        $form = new \ColissimoPickupPoint\Form\FreeShipping($this->getRequest());
        $response=null;

        try {
            $vform = $this->validateForm($form);
            $freeshipping = $vform->get('freeshipping')->getData();

            $deliveryFreeshipping = ColissimoPickupPointFreeshippingQuery::create()->findOneById(1);
            $deliveryFreeshipping
                ->setActive($freeshipping)
                ->save()
            ;
            $response = Response::create('');
        } catch (\Exception $e) {
            $response = JsonResponse::create(array('error' => $e->getMessage()), 500);
        }
        return $response;
    }

    public function setFreeShippingFrom()
    {
        if (null !== $response = $this
                ->checkAuth(array(AdminResources::MODULE), array('ColissimoPickupPoint'), AccessManager::UPDATE)) {
            return $response;
        }

        $data = $this->getRequest()->request;

        $price = $data->get('price') === '' ? null : $data->get('price');

        if ($price < 0) {
            $price = null;
        }

        ColissimoPickupPointFreeshippingQuery::create()
            ->findOneById(1)
            ->setFreeshippingFrom($price)
            ->save()
        ;

        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            array(),
            array (
                'current_tab'=> 'prices_slices_tab',
                'module_code'=> 'ColissimoPickupPoint',
                '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction',
                'price_error_id' => null,
                'price_error' => null
            )
        );
    }

    /**
     * @return mixed|null|\Symfony\Component\HttpFoundation\Response
     * @throws PropelException
     */
    public function setAreaFreeShipping()
    {
        if (null !== $response = $this
                ->checkAuth(array(AdminResources::MODULE), array('ColissimoPickupPoint'), AccessManager::UPDATE)) {
            return $response;
        }

        $data = $this->getRequest()->request;

        try {
            $data = $this->getRequest()->request;

            $colissimo_pickup_area_id = $data->get('area-id');
            $cartAmount = $data->get('cart-amount');

            if ($cartAmount < 0 || $cartAmount === '') {
                $cartAmount = null;
            }

            $aeraQuery = AreaQuery::create()->findOneById($colissimo_pickup_area_id);
            if (null === $aeraQuery) {
                return null;
            }

            $colissimoPickupPointAreaFreeshippingQuery = ColissimoPickupPointAreaFreeshippingQuery::create()
                ->filterByAreaId($colissimo_pickup_area_id)
                ->findOne();

            if (null === $colissimoPickupPointAreaFreeshippingQuery) {
                $colissimoPickupPointFreeShipping = new ColissimoPickupPointAreaFreeshipping();

                $colissimoPickupPointFreeShipping
                    ->setAreaId($colissimo_pickup_area_id)
                    ->setCartAmount($cartAmount)
                    ->save();
            }

            $cartAmountQuery = ColissimoPickupPointAreaFreeshippingQuery::create()
                ->filterByAreaId($colissimo_pickup_area_id)
                ->findOneOrCreate()
                ->setCartAmount($cartAmount)
                ->save();

        } catch (\Exception $e) {
        }

        return $this->generateRedirectFromRoute(
            'admin.module.configure',
            array(),
            array(
                'current_tab' => 'prices_slices_tab_' . $data->get('area_freeshipping'),
                'module_code' => 'ColissimoPickupPoint',
                '_controller' => 'Thelia\\Controller\\Admin\\ModuleController::configureAction',
                'price_error_id' => null,
                'price_error' => null
            )
        );
    }
}
