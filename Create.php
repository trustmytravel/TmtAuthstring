<?php

namespace TmtAuthstring;

class Create
{
    /**
     * Date stamp for the key in YmdHis format.
     *
     * @var string.
     */
    protected $dateStamp = '';

    /**
     * Sets date stamp.
     *
     * @return void
     */
    public function setDateStamp()
    {
        $dateObject      = new \DateTime('now', new \DateTimeZone('GMT'));
        $this->dateStamp = $dateObject->format('YmdHis');
    }

    /**
     * Generates the auth string.
     *
     * @param  integer $channel_id       The ID of the channel the auth is for.
     * @param  string  $channel_currency The base currency of the channel as a three letter ISO code.
     * @param  integer $booking_total    The total of the booking in base currency as a cent value.
     * @param  string  $channel_secret   The secret key for the channel the auth is for.
     * @return string                    Hashed and salted auth key.
     */
    public function getAuthstring($channel_id, $channel_currency, $booking_total, $channel_secret)
    {
        $this->setDateStamp();

        $varString = $this->getVarString($channel_id, $channel_currency, $booking_total);

        $authString       = hash('sha256', $varString);
        $saltedAuthString = hash('sha256', $authString . $channel_secret);
        
        return $saltedAuthString . $this->dateStamp;
    }

    /**
     * Concatenates relevant booking variables into a query string.
     *
     * @param  integer $channel_id         The ID of the channel the auth is for.
     * @param  string  $booking_currencies The base currency of the channel the auth is for as a three letter ISO code.
     * @param  integer $booking_total      The total of the booking in base currency as a cent value.
     * @return string                      Booking variables as a query string.
     */
    public function getVarString($channel_id, $channel_currency, $booking_total)
    {
        $booking_vars = [
            'channels'   => $channel_id,
            'currencies' => $channel_currency,
            'total'      => $booking_total,
            'timestamp'  => $this->dateStamp,
        ];

        return implode('&', $booking_vars);
    }
}
