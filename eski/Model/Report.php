<?php

class Report extends AppModel {

    public $name = 'Report';
    public $useTable = false;

    function getAdvertCountByRegions($regions = NULL, $startDate = NULL, $endDate = NULL) {
        if ($regions == NULL) {
            $regions = '';
        }
        if ($startDate == NULL) {
            $startDate = '2000-01-01';
        }
        if ($endDate == NULL) {
            $endDate = '2100-01-01';
        }
        $results = $this->query('SELECT lu_city.name city,
                                        lu_county.name county,
                                        lu_neighborhood.name neighborhood,
                                        count(*) count
                                   FROM dt_adverts da
                                        LEFT JOIN dt_advert_details add_date
                                           ON     da.advert_id = add_date.advert_id
                                              AND add_date.detail_class_id = 9
                                        LEFT JOIN dt_advert_details city
                                           ON da.advert_id = city.advert_id AND city.detail_class_id = 13
                                        LEFT JOIN dt_advert_details county
                                           ON da.advert_id = county.advert_id AND county.detail_class_id = 14
                                        LEFT JOIN dt_advert_details neighborhood
                                           ON     da.advert_id = neighborhood.advert_id
                                              AND neighborhood.detail_class_id = 93
                                        LEFT JOIN lu_city
                                           ON city.advert_detail = lu_city.city_id
                                        LEFT JOIN lu_county
                                           ON county.advert_detail = lu_county.county_id
                                        LEFT JOIN lu_neighborhood
                                           ON neighborhood.advert_detail = lu_neighborhood.neighborhood_id
                                  WHERE     da.status = "active"
                                        AND date(add_date.advert_detail) BETWEEN "' . $startDate . '" AND "' . $endDate . '"
                                        AND concat(lu_city.name,
                                                   ", ",
                                                   lu_county.name,
                                                   ", ",
                                                   lu_neighborhood.name) LIKE
                                               "' . $regions . '%"
                                 GROUP BY lu_city.city_id,
                                          lu_county.county_id,
                                          lu_neighborhood.neighborhood_id');
        return $results;
    }

    function getAdvertCountByMonthly($regions = NULL) {
        if ($regions == NULL) {
            $regions = '';
        }

        $results = $this->query('SELECT a.date, a.count
                                FROM (SELECT concat(year(date(add_date.advert_detail)),
                                                    "-",
                                                    month(date(add_date.advert_detail)))
                                                date,
                                             count(*) count,
                                             date(add_date.advert_detail) _order
                                        FROM dt_adverts da
                                             LEFT JOIN dt_advert_details add_date
                                                ON     da.advert_id = add_date.advert_id
                                                   AND add_date.detail_class_id = 9
                                             LEFT JOIN dt_advert_details city
                                                ON     da.advert_id = city.advert_id
                                                   AND city.detail_class_id = 13
                                             LEFT JOIN dt_advert_details county
                                                ON     da.advert_id = county.advert_id
                                                   AND county.detail_class_id = 14
                                             LEFT JOIN dt_advert_details neighborhood
                                                ON     da.advert_id = neighborhood.advert_id
                                                   AND neighborhood.detail_class_id = 93
                                             LEFT JOIN lu_city
                                                ON city.advert_detail = lu_city.city_id
                                             LEFT JOIN lu_county
                                                ON county.advert_detail = lu_county.county_id
                                             LEFT JOIN lu_neighborhood
                                                ON neighborhood.advert_detail =
                                                      lu_neighborhood.neighborhood_id
                                       WHERE     da.status = "active"
                                             AND concat(lu_city.name,
                                                        ", ",
                                                        lu_county.name,
                                                        ", ",
                                                        lu_neighborhood.name) LIKE
                                                    "' . $regions . '%"
                                      GROUP BY concat(month(date(add_date.advert_detail)),
                                                      " - ",
                                                      year(date(add_date.advert_detail)))) AS a
                              ORDER BY a._order');
        return $results;
    }

    function getAdvertCountByDaily($regions = NULL) {
        if ($regions == NULL) {
            $regions = '';
        }

        $results = $this->query('SELECT a.date, a.count
                                FROM (SELECT date(add_date.advert_detail) date,
                                             count(*) count
                                        FROM dt_adverts da
                                             LEFT JOIN dt_advert_details add_date
                                                ON     da.advert_id = add_date.advert_id
                                                   AND add_date.detail_class_id = 9
                                             LEFT JOIN dt_advert_details city
                                                ON     da.advert_id = city.advert_id
                                                   AND city.detail_class_id = 13
                                             LEFT JOIN dt_advert_details county
                                                ON     da.advert_id = county.advert_id
                                                   AND county.detail_class_id = 14
                                             LEFT JOIN dt_advert_details neighborhood
                                                ON     da.advert_id = neighborhood.advert_id
                                                   AND neighborhood.detail_class_id = 93
                                             LEFT JOIN lu_city
                                                ON city.advert_detail = lu_city.city_id
                                             LEFT JOIN lu_county
                                                ON county.advert_detail = lu_county.county_id
                                             LEFT JOIN lu_neighborhood
                                                ON neighborhood.advert_detail =
                                                      lu_neighborhood.neighborhood_id
                                       WHERE     da.status = "active"
                                             AND concat(lu_city.name,
                                                        ", ",
                                                        lu_county.name,
                                                        ", ",
                                                        lu_neighborhood.name) LIKE
                                                     "' . $regions . '%"
                                      GROUP BY date(add_date.advert_detail)) AS a
                              ORDER BY a.date');
        return $results;
    }

    function getProfits() {
        $totalProfit = $this->query('select sum(gross_profit) from vw_bookings_fanout where status = "active"');

        $total = $totalProfit[0][0]['sum(gross_profit)'];

        $todaysTotalProfit = $this->query('select sum(gross_profit) from vw_bookings_fanout where status = "active" AND DATE(booking_date)=DATE(NOW()) GROUP BY DATE(booking_date)');
        $todays = $todaysTotalProfit[0][0]['sum(gross_profit)'];
        $monhly = $this->query('select * from (SELECT Year(booking_date) "year", MONTH(booking_date) "month", sum(gross_profit) "total"
        FROM vw_bookings_fanout
        WHERE status = "active"
        GROUP BY MONTH(booking_date),Year(booking_date))monthly order by monthly.year desc ,monthly.month desc');
        $result['totalProfit'] = $total;
        $result['todaysTotalProfit'] = $todays;
        $result['monthlyTotalProfits'] = $monhly;
        return $result;
    }

    public function getHouseholderPayments() {
        $results = $this->query('SELECT *
                                    FROM (SELECT count(*) "count",
                                                 sum(dbf.price) price,
                                                 month(dbf.transaction_date) "month",
                                                 year(dbf.transaction_date) "year"
                                            FROM dt_booking_fanout dbf
                                                 JOIN dt_booking db
                                                    ON dbf.booking_id = db.booking_id
                                                 JOIN dt_advert_details dad
                                                    ON     dad.advert_id = db.advert_id
                                                       AND dad.detail_class_id = 66
                                                       AND dad.advert_detail <> db.lessor_user_s_id
                                           WHERE     dbf.transaction_type_id = 2
                                                 AND db.status = "active"
                                                 AND dbf.status = "pending"
                                          GROUP BY month(dbf.transaction_date), year(dbf.transaction_date)) a
                                  ORDER BY `year`, month');
        $today = $this->query('SELECT *
                                    FROM (SELECT count(*) "count",
                                                 sum(dbf.price) price,
                                                 month(dbf.transaction_date) "month",
                                                 year(dbf.transaction_date) "year"
                                            FROM dt_booking_fanout dbf
                                                 JOIN dt_booking db
                                                    ON dbf.booking_id = db.booking_id
                                                 JOIN dt_advert_details dad
                                                    ON     dad.advert_id = db.advert_id
                                                       AND dad.detail_class_id = 66
                                                       AND dad.advert_detail <> db.lessor_user_s_id
                                           WHERE     dbf.transaction_type_id = 2
                                                 AND db.status = "active"
                                                 AND dbf.status = "pending"
                                                 AND dbf.transaction_date <= now()
                                  )a order by `year`, month');
        $return = array();

        $return['today']['count'] = $today[0]['a']['count'];
        $return['today']['price'] = $today[0]['a']['price'];
        $return['total']['count'] = 0;
        $return['total']['price'] = 0;

        foreach ($results as $result) {
            $return['total']['count'] += $result['a']['count'];
            $return['total']['price'] += $result['a']['price'];
            $return[$result['a']['month'] . '-' . $result['a']['year']]['count'] = $result['a']['count'];
            $return[$result['a']['month'] . '-' . $result['a']['year']]['price'] = $result['a']['price'];
        }

        return $return;
    }

    public function getPendingPayments() {
        $results = $this->query('SELECT *
                                FROM (SELECT count(*) "count",
                                             sum(dbf.price) price,
                                             month(dbf.transaction_date) "month",
                                             year(dbf.transaction_date) "year"
                                        FROM dt_booking_fanout dbf
                                             JOIN dt_booking db
                                                ON dbf.booking_id = db.booking_id
                                             JOIN dt_advert_details dad
                                                ON     dad.advert_id = db.advert_id
                                                   AND dad.detail_class_id = 66
                                                   AND dad.advert_detail <> db.lessor_user_s_id
                                       WHERE     dbf.transaction_type_id = 1
                                             AND db.status = "active"
                                             AND dbf.status = "pending"
                                      GROUP BY month(dbf.transaction_date), year(dbf.transaction_date)) a
                              ORDER BY `year`, month');
        $today = $this->query('SELECT *
                                FROM (SELECT count(*) "count",
                                             sum(dbf.price) price,
                                             month(dbf.transaction_date) "month",
                                             year(dbf.transaction_date) "year"
                                        FROM dt_booking_fanout dbf
                                             JOIN dt_booking db
                                                ON dbf.booking_id = db.booking_id
                                             JOIN dt_advert_details dad
                                                ON     dad.advert_id = db.advert_id
                                                   AND dad.detail_class_id = 66
                                                   AND dad.advert_detail <> db.lessor_user_s_id
                                       WHERE     dbf.transaction_type_id = 1
                                             AND db.status = "active"
                                             AND dbf.status = "pending"
                                             AND dbf.transaction_date <= now()
                              )a order by `year`, month');
        $return = array();

        $return['today']['count'] = $today[0]['a']['count'];
        $return['today']['price'] = $today[0]['a']['price'];
        $return['total']['count'] = 0;
        $return['total']['price'] = 0;

        foreach ($results as $result) {
            $return['total']['count'] += $result['a']['count'];
            $return['total']['price'] += $result['a']['price'];
            $return[$result['a']['month'] . '-' . $result['a']['year']]['count'] = $result['a']['count'];
            $return[$result['a']['month'] . '-' . $result['a']['year']]['price'] = $result['a']['price'];
        }

        return $return;
    }

}

?>
