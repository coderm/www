<?php

class Invoice extends AppModel {

    public $name = 'Invoice';
    public $useTable = false;

    public function getPreviousMonthsInvoice($userId = null) {
        if ($userId == null) {

            return $this->query('select
                  count(booking_id)
                 ,max(start_date)
                 ,sum(gross_profit)
                 ,householder_user_s_id invoice_user_id
                 ,householder invoice_user
                 ,"active" status
                from
                  vw_bookings_fanout
                WHERE
                  status IN ("active") and
                 DATE_FORMAT(start_date,"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
                  and booking_id NOT IN (select booking_id from dt_booking_fanout where transaction_type_id = 1 and banking_account_id = 6)
                  and invoice <> 1
                  and gross_profit <> 0
                group by
                  householder_user_s_id
                Union ALL
                select
                  count(vbf.booking_id)
                 ,(select
                     max(transaction_date)
                   from
                     dt_booking_fanout
                   where
                     booking_id = vbf.booking_id and
                     transaction_type_id = 6)
                 ,sum((select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 1) -
                      (select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 6))
                 ,vbf.renter_user_s_id invoice_user_id
                 ,vbf.renter invoice_user
                 ,"cancel"
                from
                  vw_bookings_fanout vbf
                WHERE
                  vbf.status IN ("cancel") and
                  DATE_FORMAT((select
                     max(transaction_date)
                   from
                     dt_booking_fanout
                   where
                     booking_id = vbf.booking_id and
                     transaction_type_id = 6),"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
                     and vbf.booking_id NOT IN (select booking_id from dt_booking_fanout where transaction_type_id = 1 and banking_account_id = 6)
                     and vbf.invoice <> 1
                     and (select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 1) -
                      (select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 6) <> 0
                 group by
                  vbf.renter_user_s_id');
        } else {
            return $this->query('select
                      booking_id
                     ,start_date
                    ,ROUND(gross_profit / 0.0118)/100 net
                    ,gross_profit - (ROUND(gross_profit / 0.0118)/100) vat
                    ,gross_profit  total
                     ,householder_user_s_id invoice_user_id
                     ,householder invoice_user
                     ,"active" status
                    from
                      vw_bookings_fanout
                    WHERE
                      status IN ("active") and
                      DATE_FORMAT(start_date,"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
                    and vw_bookings_fanout.booking_id NOT IN (select booking_id from dt_booking_fanout where transaction_type_id = 1 and banking_account_id = 6)
                    and householder_user_s_id = ' . $userId . '
                    and invoice <> 1
                    and gross_profit <> 0
                Union ALL
                    select
                      vbf.booking_id
                     ,(select
                        max(transaction_date)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 6)
                     ,ROUND(((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) / 0.0118)/100 net
                             ,((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) - 
                             ROUND(((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) / 0.0118)/100 vat
                             ,((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) total
                     ,vbf.renter_user_s_id invoice_user_id
                     ,vbf.renter invoice_user
                     ,"cancel"
                    from
                      vw_bookings_fanout vbf
                    WHERE
                      vbf.status IN ("cancel") and
                       DATE_FORMAT((select
                     max(transaction_date)
                   from
                     dt_booking_fanout
                   where
                     booking_id = vbf.booking_id and
                     transaction_type_id = 6),"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
                         and vbf.booking_id NOT IN (select booking_id from dt_booking_fanout where transaction_type_id = 1 and banking_account_id = 6)
                         and vbf.invoice <> 1
                     and (select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 1) -
                      (select
                         sum(price)
                       from
                         dt_booking_fanout
                       where
                         booking_id = vbf.booking_id and
                         transaction_type_id = 6) <> 0
                         and vbf.renter_user_s_id = ' . $userId);
        }
    }

    public function getInvoiceData($bookingId) {
        $results = $this->query('select
            booking_id
            ,start_date
            ,ROUND(gross_profit / 0.0118)/100 net
            ,gross_profit - (ROUND(gross_profit / 0.0118)/100) vat
            ,gross_profit  total
            ,householder_user_s_id invoice_user_id
            ,householder invoice_user
            ,renter
            ,"active" status
            from
            vw_bookings_fanout
            WHERE
            status IN ("active") and
            DATE_FORMAT(start_date,"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
            and booking_id IN (' . $bookingId . ')
            Union ALL
            select
            vbf.booking_id
            ,(select
            max(transaction_date)
            from
            dt_booking_fanout
            where
            booking_id = vbf.booking_id and
            transaction_type_id = 6)
            ,ROUND(((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) / 0.0118)/100 net
                             ,((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) - 
                             ROUND(((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) / 0.0118)/100 vat
                             ,((select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 1) -
                          (select
                             sum(price)
                           from
                             dt_booking_fanout
                           where
                             booking_id = vbf.booking_id and
                             transaction_type_id = 6)) total
            ,vbf.renter_user_s_id invoice_user_id
            ,vbf.renter invoice_user
            ,renter
            ,"cancel"
            from
            vw_bookings_fanout vbf
            WHERE
            vbf.status IN ("cancel") and
            DATE_FORMAT((select
            max(transaction_date)
            from
            dt_booking_fanout
            where
            booking_id = vbf.booking_id and
            transaction_type_id = 6),"%Y-%m-01") < DATE_FORMAT(now(),"%Y-%m-01")
            and vbf.booking_id IN (' . $bookingId . ')');
        $net = 0;
        $vat = 0;
        $total = 0;

        foreach ($results as $result) {
            $net += $result['0']['net'];
            $vat += $result['0']['vat'];
            $total += $result['0']['total'];
        }
        $results['total']['net'] = $net;
        $results['total']['vat'] = $vat;
        $results['total']['total'] = $total;
        return $results;
    }

    public function setInvoiced($bookingIds) {
        return $this->query('update dt_booking SET invoice = 1 WHERE booking_id IN(' . $bookingIds . ')');
    }

}

