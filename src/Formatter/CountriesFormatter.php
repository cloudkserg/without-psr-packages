<?php
/**
 * Created by PhpStorm.
 * User: dns
 * Date: 03.02.18
 * Time: 18:04
 */

namespace Src\Formatter;


use Src\Model\Counter;

class CountriesFormatter
{

    /**
     * @param Counter[] $counters
     * @return array
     */
    public function format(array $counters) : array
    {
        return collect($counters)->map(function (Counter $counter) {
            return [
                'event' => (string)$counter->getEvent(),
                'country' => $counter->getCountry(),
                'count' => (int)$counter->getCount()
            ];
        })->toArray();
    }

    /**
     * @param Counter[] $counters
     * @return string
     */
    public function formatCsv(array $counters) : string
    {
        return collect($counters)->reduce(function (string $output, Counter $counter) {
            return $output . sprintf("%s,%s,%s\n",
                (string)$counter->getEvent(),
                $counter->getCountry(),
                (int)$counter->getCount()
            );
        }, '');
    }


}
