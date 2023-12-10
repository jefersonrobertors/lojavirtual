<?php

declare(strict_types=1);

namespace app\helpers;

final class Rating {

    private const STAR_COUNT = 5;

    public static function create() : self {
        return new self;
    }

    public function getStarIconUnfilled(int $width = 8) : string {
        return sprintf('<i class="bi bi-star me-2 fs-%d"></i>', $width);
    }
    
    public function getStarIcon(int $width = 8) : string {
        return sprintf('<i class="bi bi-star-fill me-2 fs-%d"></i>', $width);
    }

    public function calc(int $reviewSum, int $reviewCount, bool $round = false) : int|float {
        if($reviewSum == 0 || $reviewCount == 0) {
            return 0;
        }
        $average = ($reviewSum / $reviewCount);
        $start = ceil($average);

        if($round) {
            $start = round($average, 1);
        }
        if($start < 0) {
            $start = 0;
        }
        if($start > self::STAR_COUNT) {
            $start = self::STAR_COUNT;
        }
        return $start;
    }

    public function repeat(int|float $times) : string {
        if(is_float($times)) {
            $times = (int) floor($times);
        }
        $end = (int) floor(self::STAR_COUNT - $times);

        if($end < 0) {
            $end = 0;
        }
        $size = 3;
        return str_repeat($this->getStarIcon($size), $times) . str_repeat($this->getStarIconUnfilled($size), $end);
    }

    public function getLabel(int|float $value) : string {
        $value = (int) floor($value);
        return match($value) {
            1 => "Ruim",
            2 => "Regular",
            3 => "Bom",
            4 => "Muito Bom",
            5 => "Excelente",
            default => ""
        };
    }

    public function getColor(int|float $width) : string {
       if($width <= 25) return 'red';
       if($width <= 50) return 'yellow';
       if($width <= 75) return 'orange';
       return 'green';
    }

    public function getReviewDetail(array $list) : string {
        $max = self::STAR_COUNT;
        $reviews = [];

        foreach(range(1, $max) as $rate) {
            if(empty($list)) {
                $reviews[$rate] = 0;
                continue;
            }
            $count = 0;
            foreach($list as $key => $entity) {
                if($entity->getRating() === $rate) {
                    $count += (int) ($entity->getRating());
                }
            }
            $reviews[$rate] = $count;
        }
        $message = '';
        $reviewCount = count($reviews);
        $star = $this->getStarIcon(6);
 
        foreach($reviews as $key => $value) {
            $width = 0;
            if($value > 0) {
                $width = ($value / $reviewCount) * 100;
            }
            if($width > 100) {
                $width = 100;
            }
            $color = $this->getColor($width);
            $total = intval($reviews[$key] / $key);
            
            $message .= '<div class="d-flex align-items-center">' . "\n";

            $message .= "\t" . '<div class="side">' . "\n";
            $message .= "\t" . '<div class="d-flex align-items-center px-2">' . $star . $key . '</div>' . "\n";
            $message .= '</div>' . "\n";
            $message .= '<div class="middle">' . "\n";
            $message .= "\t" . '<div class="bar-container">' . "\n";
            $message .= "\t" . '<div class="bar" style="width:' . $width . '%; background-color: ' . $color . ';"></div>' . "\n";
            $message .= '</div>' . "\n";
            $message .= '</div>' . "\n";

            $message .= "\t" . '<div class="side right">' . "\n";
            $message .= "\t" . '<div class="text-muted">(' . $total . ')</div>' . "\n";
            $message .= '</div>' . "\n";

            $message .= '</div>' . "\n";
        }
        return $message;
    }
}
?>