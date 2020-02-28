<?php
namespace jones\novaposhta;

/**
 * Class InternetDocument
 * @package jones\novaposhta
 * @author sergii gamaiunov <hello@webkadabra.com>
 *
 * This model contain methods to create and configure return orders
 */
final class AdditionalService extends Api
{
    const SCENARIO_CHECK    = 'CheckPossibilityCreateReturn';
    const SCENARIO_CREATE   = 'save';
    const SCENARIO_DELETE   = 'delete';
    const SCENARIO_LIST     = 'getReturnOrdersList';
    const SCENARIO_REDIRECT_LIST = 'getRedirectionOrdersList';

    // check
    public $Number;

    // create
    public $IntDocNumber;
    public $PaymentMethod;
    public $Reason;
    public $SubtypeReason;
    public $Note;
    public $OrderType;
    public $ReturnAddressRef;

    // delete
    public $Ref;

    // list and redirectList (with "Number" and "Ref")
    public $BeginDate;
    public $EndDate;
    public $Page;
    public $Limit;


    public function rules()
    {
        return [
            [['IntDocNumber', 'PaymentMethod', 'Reason', 'SubtypeReason', 'OrderType', 'ReturnAddressRef'], 'required', 'on' => static::SCENARIO_CREATE],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DELETE]   = ['Ref'];
        $scenarios[self::SCENARIO_CHECK]    = ['Number'];
        $scenarios[self::SCENARIO_CREATE]   = ['IntDocNumber', 'PaymentMethod', 'Reason', 'SubtypeReason', 'OrderType', 'ReturnAddressRef', 'Note'];
        $scenarios[self::SCENARIO_LIST]     = ['Ref', 'Number', 'BeginDate', 'EndDate', 'Page', 'Limit'];
        $scenarios[self::SCENARIO_REDIRECT_LIST] = ['Ref', 'Number', 'BeginDate', 'EndDate', 'Page', 'Limit'];
        return $scenarios;
    }

    public function checkPossibilityCreateReturn(){
        return $this->call(self::SCENARIO_CHECK);
    }

    public function create(){
        return $this->call(self::SCENARIO_CREATE);
    }

    public function delete(){
        return $this->call(self::SCENARIO_DELETE);
    }

    public function getList(){
        return $this->call(self::SCENARIO_LIST);
    }

    public function getRedirectList(){
        return $this->call(self::SCENARIO_REDIRECT_LIST);
    }
}
