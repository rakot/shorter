<?php

/**
 * Kohana3 Model filters in Yii
 * Example:
 * News::model()->findAll(Ko3::db()->where('id_news','<',5)->offset(2)->order('date','DESC')->order('id_news','DESC')->limit(2)->finish());
 *
 * put it in protected/components
 */
class Ko3
{
    protected $_build = array();

    protected $_where = array();

    public static function get(&$array, $key, $default = null)
    {
        return (isset($array[$key])) ? $array[$key] : $default;
    }

    public static function db()
    {
        return new Ko3();
    }

    public function limit($limit = 20)
    {
        $this->_build['limit'] = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->_build['offset'] = $offset;
        return $this;
    }

    public function order($field, $type = 'ASC')
    {
        if(!isset($this->_build['order']))
        {
            $this->_build['order'] = "`$field` $type";
        }
        else
        {
            $this->_build['order'] .= ", `$field` $type";
        }
        return $this;
    }

    /**
     * Alias of and_where()
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function where($column, $op, $value)
    {
        return $this->and_where($column, $op, $value);
    }

    /**
     * Creates a new "AND WHERE" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function and_where($column, $op, $value)
    {
        $this->_where[] = array('AND' => array($column, $op, $value));

        return $this;
    }

    /**
     * Creates a new "OR WHERE" condition for the query.
     *
     * @param   mixed   $column  column name or array($column, $alias) or object
     * @param   string  $op      logic operator
     * @param   mixed   $value   column value
     * @return  $this
     */
    public function or_where($column, $op, $value)
    {
        $this->_where[] = array('OR' => array($column, $op, $value));

        return $this;
    }

    /**
     * Alias of and_where_open()
     *
     * @return  $this
     */
    public function where_open()
    {
        return $this->and_where_open();
    }

    /**
     * Opens a new "AND WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function and_where_open()
    {
        $this->_where[] = array('AND' => '(');

        return $this;
    }

    /**
     * Opens a new "OR WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function or_where_open()
    {
        $this->_where[] = array('OR' => '(');

        return $this;
    }

    /**
     * Closes an open "WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function where_close()
    {
        return $this->and_where_close();
    }

    /**
     * Closes an open "WHERE (...)" grouping or removes the grouping when it is
     * empty.
     *
     * @return  $this
     */
    public function where_close_empty()
    {
        $group = end($this->_where);

        if ($group AND reset($group) === '(')
        {
            array_pop($this->_where);

            return $this;
        }

        return $this->where_close();
    }

    /**
     * Closes an open "WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function and_where_close()
    {
        $this->_where[] = array('AND' => ')');

        return $this;
    }

    /**
     * Closes an open "WHERE (...)" grouping.
     *
     * @return  $this
     */
    public function or_where_close()
    {
        $this->_where[] = array('OR' => ')');

        return $this;
    }

    public function finish()
    {
        $this->_build['condition'] = $this->_compile_conditions();
        return $this->_build;
    }

    protected function _compile_conditions()
    {
        $last_condition = NULL;
        $sql = '';

        foreach ($this->_where as $group)
        {
            // Process groups of conditions
            foreach ($group as $logic => $condition)
            {
                if ($condition === '(')
                {
                    if ( ! empty($sql) AND $last_condition !== '(')
                    {
                        // Include logic operator
                        $sql .= ' '.$logic.' ';
                    }

                    $sql .= '(';
                }
                elseif ($condition === ')')
                {
                    $sql .= ')';
                }
                else
                {
                    if ( ! empty($sql) AND $last_condition !== '(')
                    {
                        // Add the logic operator
                        $sql .= ' '.$logic.' ';
                    }

                    // Split the condition
                    list($column, $op, $value) = $condition;

                    if ($value === NULL)
                    {
                        if ($op === '=')
                        {
                            // Convert "val = NULL" to "val IS NULL"
                            $op = 'IS';
                        }
                        elseif ($op === '!=')
                        {
                            // Convert "val != NULL" to "valu IS NOT NULL"
                            $op = 'IS NOT';
                        }
                    }

                    // Database operators are always uppercase
                    $op = strtoupper($op);

                    if ($op === 'BETWEEN' AND is_array($value))
                    {
                        // BETWEEN always has exactly two arguments
                        list($min, $max) = $value;

                        // Quote the min and max value
                        $value = $this->_addParam($min).' AND '.$this->_addParam($max);
                    }
                    elseif($op === 'IN' && is_array($value))
                    {
                        $tmp_val = array();
                        foreach($value as $val)
                        {
                            $tmp_val[] = $this->_addParam($val);
                        }
                        $value = '('.implode(', ',$tmp_val).')';
                    }
                    else
                    {
                        // Quote the value, it is not a parameter
                        $value = $this->_addParam($value);
                    }

                    if ($column)
                    {
                        $column = "`$column`";
                    }

                    // Append the statement to the query
                    $sql .= trim($column.' '.$op.' '.$value);
                }

                $last_condition = $condition;
            }
        }

        return $sql;
    }



    protected function _addParam($value)
    {
        if(!isset($this->_build['params']))
        {
            $this->_build['params'] = array();
        }
        $cnt = count($this->_build['params'])+1;

        $this->_build['params'][':param'.$cnt] = $value;

        return ':param'.$cnt;
    }
}