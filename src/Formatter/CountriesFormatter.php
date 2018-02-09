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
        return array_map(function (Counter $counter) {
            return [
                'event' => (string)$counter->getEvent(),
                'country' => $counter->getCountry(),
                'count' => (int)$counter->getCount()
            ];
        }, $counters);
    }

    /**
     * @param Counter[] $counters
     * @return string
     */
    public function formatCsv(array $counters) : string
    {
        return array_reduce($counters, function (string $output, Counter $counter) {
            return $output . sprintf("%s,%s,%s\n",
                (string)$counter->getEvent(),
                $counter->getCountry(),
                (int)$counter->getCount()
            );
        }, '');
    }


}
