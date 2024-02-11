<?php
/**
 * Simple trait to set controller orderbys
 *
 * User: Arushad
 * Date: 06/10/2016
 * Time: 16:28
 */

namespace Javaabu\Helpers\Traits;

use Illuminate\Http\Request;

trait HasOrderbys
{
    protected static array $orderbys = [];
    protected static array $orders = [];

    /**
     * Get order bys
     */
    public static function getOrderbys(): array
    {
        //first initialize
        if (empty(static::$orderbys)) {
            static::initOrderbys();
        }

        return static::$orderbys;
    }

    /**
     * Initialize orderbys
     */
    protected static function initOrderbys()
    {
        static::$orderbys = [
            'name' => __('Name'),
            'created_at' => __('Created At'),
            'id' => __('ID'),
        ];
    }

    /**
     * Get orders
     */
    public static function getOrders(): array
    {
        //first initialize
        if (empty(static::$orders)) {
            static::initOrders();
        }

        return static::$orders;
    }

    /**
     * Initialize orders
     */
    protected static function initOrders()
    {
        static::$orders = [
            'ASC' => __('Ascending'),
            'DESC' => __('Descending'),
        ];
    }

    /**
     * Get the order by field
     *
     * @param Request $request
     * @param string $default
     * @return string
     */
    protected function getOrderBy(Request $request, $default)
    {
        return array_key_exists($request->orderby, self::getOrderbys()) ? $request->orderby : $default;
    }

    /**
     * Get the default sorting order
     *
     * @param Request $request
     * @param string $default
     * @param array|string $override
     * @param null $orderby
     * @return string
     */
    protected function getOrder(Request $request, $override = [], ?string $orderby = null, string $default = 'ASC'): string
    {
        if ($override && ! is_array($override)) {
            $override = [$override];
        }

        // get the requested order
        $order = strtoupper($request->order);

        if (empty($order)) {
            // if no order is specified and the order by is an override field
            // then use the inverse of the default order
            if (in_array($orderby, $override)) {
                return $default == 'ASC' ? 'DESC' : 'ASC';
            }

            return $default;
        }

        // return the specified order
        return $order == 'ASC' ? 'ASC' : 'DESC';
    }
}
