<?php

include_once '../model/Manager.php';

class Validator
{

    const message = [
        'required' => 'Este campo é obrigatorio',
        'cpfOrCnpj' => 'O numero do documento é invalido',
        'unique' => 'O campo #field já existe'
    ];

    protected $rules;
    protected $data;
    protected $errors = false;


    public function __construct(array $rules, array $data)
    {
        $this->rules = $rules;
        $this->data = $data;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                if (!$this->$rule($field)) {
                    $this->errors[$field] = str_replace("#field", $field, self::message[$rule]);
                    break;
                }
            }
        }

        return $this->getErrors();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function required($field)
    {
        if (empty($this->data[$field])) {
            return false;
        }
        return true;
    }

    public function cpfOrCnpj($field)
    {
        return $this->data['type'] == 'pf' ? $this->cpf($this->data['document']) : $this->cnpj($this->data['document']);
    }


    public function cpf($cpf)
    {
        if (empty($cpf)) {
            return false;
        }

        $cpf = preg_replace("/[^0-9]/", "", $cpf);
        $cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11) {
            return false;
        } else if ($cpf == '00000000000' ||
            $cpf == '11111111111' ||
            $cpf == '22222222222' ||
            $cpf == '33333333333' ||
            $cpf == '44444444444' ||
            $cpf == '55555555555' ||
            $cpf == '66666666666' ||
            $cpf == '77777777777' ||
            $cpf == '88888888888' ||
            $cpf == '99999999999') {
            return false;

        } else {
            for ($t = 9; $t < 11; $t++) {

                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf[$c] * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf[$c] != $d) {
                    return false;
                }
            }
            return true;
        }
    }

    public function cnpj($cnpj)
    {
        if (empty($cnpj)) {
            return false;
        }

        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);
        $cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14) {
            return false;
        } else if ($cnpj == '00000000000000' ||
            $cnpj == '11111111111111' ||
            $cnpj == '22222222222222' ||
            $cnpj == '33333333333333' ||
            $cnpj == '44444444444444' ||
            $cnpj == '55555555555555' ||
            $cnpj == '66666666666666' ||
            $cnpj == '77777777777777' ||
            $cnpj == '88888888888888' ||
            $cnpj == '99999999999999') {
            return false;

        } else {

            $j = 5;
            $k = 6;
            $soma1 = 0;
            $soma2 = 0;

            for ($i = 0; $i < 13; $i++) {

                $j = $j == 1 ? 9 : $j;
                $k = $k == 1 ? 9 : $k;

                $soma2 += ($cnpj[$i] * $k);

                if ($i < 12) {
                    $soma1 += ($cnpj[$i] * $j);
                }

                $k--;
                $j--;

            }

            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;

            return (($cnpj[12] == $digito1) and ($cnpj[13] == $digito2));

        }
        return true;
    }

    function unique($field)
    {
        $manager = new Manager();
        $result = $manager->getByField("users", $field, $this->data[$field]);
        return empty($result);
    }
}