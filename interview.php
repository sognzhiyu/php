<?php
class Main
{
    public function test(float $length, float $width, float $height, float $weight): array
    {
        // 转换 cm 到 inches, kg 到 lb
        $lengthToInches = ceil($length / 2.54);
        $widthToInches = ceil($width / 2.54);
        $heightToInches = ceil($height / 2.54);
        $weightToLbs = ceil($weight / 0.454);

        // 计算围长
        $girth = $lengthToInches + 2 * ($widthToInches + $heightToInches);
        echo $girth;

        // 计算体积重
        $volumetricWeight = ceil($lengthToInches * $widthToInches * $heightToInches / 250);

        // 实重是体积重和实际重量之间的最大值
        $actualWeight = max($weightToLbs, $volumetricWeight);

        $types = [];

        // 判断 OUT_SPACE
        if ($actualWeight > 150 || $lengthToInches > 108 || $girth > 165) {
            $types[] = 'OUT_SPACE';
        }
        // 判断 OVERSIZE (若 OUT_SPACE 不成立)
        elseif ($girth > 130 && $girth <= 165 || ($lengthToInches >= 96 && $lengthToInches < 108)) {
            $types[] = 'OVERSIZE';
        }
        // 判断 AHS (若 OUT_SPACE 和 OVERSIZE 不成立)
        else {
            if ($actualWeight > 50 && $actualWeight <= 150) {
                $types[] = 'AHS-WEIGHT';
            }
            if ($girth > 105 || ($lengthToInches >= 48 && $lengthToInches < 108) || $widthToInches >= 30) {
                $types[] = 'AHS-SIZE';
            }
        }

        return $types;
    }
}

// 测试
$obj = new Main();
var_dump($obj->test(68, 70, 60, 23)); // 输出应该是:OVERSIZE，不是： AHS-WEIGHT, AHS-SIZE
var_dump($obj->test(114.50, 42, 26, 47.5)); // 输出: AHS-WEIGHT
var_dump($obj->test(162, 60, 11, 14)); // 输出: AHS-SIZE
var_dump($obj->test(113, 64, 42.5, 35.85)); // 输出: OVERSIZE
var_dump($obj->test(114.5, 17, 51.5, 16.5)); // 输出: []
