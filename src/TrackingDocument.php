<?php
namespace jones\novaposhta;

/**
 * Class TrackingDocument
 * @package jones\novaposhta
 * @author sergii gamaiunov <hello@webkadabra.com>
 */
class TrackingDocument  extends Api
{
    const SCENARIO_GET_STATUSDOCUMENTS = 'getStatusDocuments';

    public $Documents;

    /**
     * Get list of counterparties
     * @param array $options
     * @param string $filter
     * @return array|bool
     */
    public function getStatusDocuments($filter = '', $options=[])
    {
        if (!is_array($filter)) {
            $filter = [
                    [
                    'DocumentNumber' => $filter,
                    'Phone' => ''
                ]
            ];
        }
        $this->setScenario(self::SCENARIO_GET_STATUSDOCUMENTS);
        $this->Documents = $filter;
        return $this->call(self::SCENARIO_GET_STATUSDOCUMENTS, $options);
    }
}
