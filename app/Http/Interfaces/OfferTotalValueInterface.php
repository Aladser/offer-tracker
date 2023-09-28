<?php

namespace App\Http\Interfaces;

interface OfferTotalValueInterface
{
    /** Общее чиспло переходов по ссылке */
    public function offerSubscriptionCount($timePeriod = null);
    /** Денежная сумма, связанная с переходами */
    public function offerMoney($timePeriod = null);
}