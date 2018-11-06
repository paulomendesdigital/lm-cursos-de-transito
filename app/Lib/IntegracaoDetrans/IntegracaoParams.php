<?php

class IntegracaoParams
{
    public $user_id;
    public $order_id;
    public $order_courses_id;
    public $cpf;
    public $cnh;
    public $cnh_category;
    public $renach;
    public $state_id;
    public $citie_id;
    public $num_certificado;
    public $data_inicio;
    public $data_fim;
    public $workload;
    public $score;
    public $course_type_id;
    public $data_matricula_detran;
    public $cod_cfc;
    public $birth;

    //crédito de aula
    public $course_code;
    public $discipline_code;
    public $data_aula;
    public $inicio_aula;
    public $fim_aula;
    public $is_exam;
    public $acertos;

    public function __construct(array $arr = null) {
        if ($arr) {
            $this->fromArray($arr);
        }
    }

    public static function createFromArray(array $arr)
    {
        return new static($arr);
    }

    public function fromArray(array $arr) {
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                $this->fromArray($val);
            } elseif (is_scalar($val)) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $val;
                }
            }
        }
    }

    public function toJson() {
        return json_encode(array_filter(get_object_vars($this)));
    }

    public function toArray() {
        return get_object_vars($this);
    }

}
