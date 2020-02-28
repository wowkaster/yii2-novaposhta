<?php

namespace jones\novaposhta;

/**
 * Class InternetDocument
 * @package jones\novaposhta
 * @author sergii gamaiunov <hello@webkadabra.com>
 *
 * This model contain methods to create and configure return orders
 */
final class AdditionalServiceGeneral extends Api
{
    const SCENARIO_CHECK = 'checkPossibilityForRedirecting';
    const SCENARIO_CREATE = 'save';
    const SCENARIO_DELETE = 'delete';

    const SERVICE_TYPE_DOORS = 'DoorsWarehouse';
    const SERVICE_TYPE_WAREHOUSE = 'WarehouseWarehouse';

    // check
    public $Number;

    // create
    public $OrderType = 'orderRedirecting';
    public $Customer = 'Sender';
    public $IntDocNumber;
    public $ServiceType; // DoorsWarehouse | WarehouseWarehouse
    public $RecipientSettlement; // for DoorsWarehouse
    public $RecipientSettlementStreet; // for DoorsWarehouse
    public $BuildingNumber; // for DoorsWarehouse
    public $NoteAddressRecipient; // for DoorsWarehouse
    public $RecipientWarehouse;
    public $Recipient;
    public $RecipientContactName;
    public $RecipientPhone;
    public $PayerType;
    public $PaymentMethod;
    public $Note;

    // delete with $OrderType
    public $Ref;

    public function rules()
    {
        return [
            [
                [
                    'OrderType',
                    'Customer',
                    'IntDocNumber',
                    'ServiceType',
                    'RecipientWarehouse',
                    'Recipient',
                    'RecipientContactName',
                    'RecipientPhone',
                    'PayerType',
                    'PaymentMethod',
                    'Note',
                ], 'required', 'on' => self::SCENARIO_CREATE
            ],
            [['RecipientSettlement', 'RecipientSettlementStreet', 'BuildingNumber', 'NoteAddressRecipient'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHECK] = ['Number'];
        $scenarios[self::SCENARIO_CREATE] = [
            'OrderType',
            'Customer',
            'IntDocNumber',
            'ServiceType',
            'RecipientWarehouse',
            'Recipient',
            'RecipientContactName',
            'RecipientPhone',
            'PayerType',
            'PaymentMethod',
            'Note',
        ];
        $scenarios[self::SCENARIO_DELETE] = ['Ref', 'OrderType'];
        return $scenarios;
    }

    public function checkPossibilityForRedirecting()
    {
        return $this->call(self::SCENARIO_CHECK);
    }

    public function create()
    {
        return $this->call(self::SCENARIO_CREATE);
    }

    public function delete()
    {
        return $this->call(self::SCENARIO_DELETE);
    }
}
