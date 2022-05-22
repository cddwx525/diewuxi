<?php
namespace swdf\base;

class controller
{
    /**
     *
     *
     */
    protected function get_behaviors()
    {
        return array();
    }


    /**
     *
     *
     */
    public function filter()
    {
        $filters = $this->get_behaviors();

        if (! empty($filters))
        {
            foreach ($filters as $filter)
            {
                if (
                    (empty($filter["actions"])) ||
                    (in_array(\swdf::$app->router["action_name"], $filter["actions"]))
                )
                {
                    if ((new $filter["class"])->run() === TRUE)
                    {
                        $result = $filter["rule"]["true"];
                    }
                    else
                    {
                        $result = $filter["rule"]["false"];
                    }

                    if ($result === TRUE)
                    {
                    }
                    else
                    {
                        return $result;
                    }
                }
                else
                {
                }
            }
        }
        else
        {
        }

        return TRUE;
    }
}
?>
