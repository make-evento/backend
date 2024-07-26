<?php

namespace App\Services;

class HumanReadableToken
{
    private $consonants = "bcdfghjklmnpqrstvwxyz";
    private $vowels = "aeiu";

    /**
     * @param int $length
     */
    public function generate(int $length): string
    {
        $token = "";
        for ($i = 0; $i < $length; $i++) {
            if ($i % 2 == 0) {
                $token .=
                    $this->consonants[rand(0, strlen($this->consonants) - 1)];
            } else {
                $token .= $this->vowels[rand(0, strlen($this->vowels) - 1)];
            }
        }

        return strtoupper($token);
    }
}
