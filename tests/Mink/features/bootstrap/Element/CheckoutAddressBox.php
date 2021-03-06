<?php

namespace Shopware\Tests\Mink\Element;

use Shopware\Tests\Mink\Helper;

/**
 * Element: CheckoutAddressBox
 * Location: Checkout address boxes
 *
 * Available retrievable properties:
 * -
 */
class CheckoutAddressBox extends MultipleElement
{
    /**
     * @var array $selector
     */
    protected $selector = ['css' => 'div.information--panel'];

    /**
     * @inheritdoc
     */
    public function getCssSelectors()
    {
        return [
            'panelTitle' => '.panel--title',
            'panelBody' => '.panel--body',
            'company' => '.address--company',
            'address' => '.address--address',
            'salutation' => '.address--salutation',
            'customerTitle' => '.address--title',
            'firstname' => '.address--firstname',
            'lastname' => '.address--lastname',
            'street' => '.address--street',
            'addLineOne' => '.address--additional-one',
            'addLineTwo' => '.address--additional-two',
            'zipcode' => '.address--zipcode',
            'city' => '.address--city',
            'stateName' => '.address--statename',
            'countryName' => '.address--countryname',
        ];
    }

    /**
     * @inheritdoc
     */
    public function getNamedSelectors()
    {
        return [
            'orChooseOtherAddress' => ['de' => 'oder andere Adresse wählen', 'en' => 'or use another address'],
            'changeAddress' => ['de' => 'Adresse ändern'],
        ];
    }

    public function hasTitle($title)
    {
        if ($this->has('css', $this->getCssSelectors()['panelTitle'])) {
            return $this->getPanelTitleProperty() === $title;
        }

        return false;
    }

    /**
     * @param $givenAddress
     * @return bool
     */
    public function containsAdress($givenAddress)
    {
        $testAddress = [];

        if ($this->has('css', $this->getCssSelectors()['firstname']) === false) {
            return false;
        }

        if (count($givenAddress) === 5) {
            $testAddress[] = $this->getCompanyOrNull();
        }

        $testAddress[] = Helper::getElementProperty($this, 'firstname') . ' ' . Helper::getElementProperty($this, 'lastname');
        $testAddress[] = Helper::getElementProperty($this, 'street');
        $testAddress[] = Helper::getElementProperty($this, 'zipcode') . ' ' . Helper::getElementProperty($this, 'city');
        $testAddress[] = Helper::getElementProperty($this, 'countryName');

        return Helper::compareArrays($givenAddress, $testAddress) === true;
    }

    private function getCompanyOrNull()
    {
        if ($this->has('css', $this->getCssSelectors()['company'])) {
            return $this->getCompanyProperty();
        }

        return null;
    }
}
