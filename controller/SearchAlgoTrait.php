<?php

trait SearchAlgoTrait
{
    public function getOrientation($src, $dst, $genreSrc, $genreDst)
    {
        $match = 0;
        if ($src == 'bisexuel' && $dst == 'bisexuel') {
            if ($genreSrc == ('homme' || 'femme') && $genreDst == ('homme' || 'femme')) {
                return (0);
            }
        }
        if ($src == 'homosexuel' && $dst == 'homosexuel') {
            if (($genreSrc == 'homme' && $genreDst == 'homme') || ($genreSrc == 'femme' && $genreDst == 'femme')) {
                return (0);
            }
        }
        if ($src == 'heterosexuel' && $dst == 'heterosexuel') {
            if ($genreSrc == 'homme' && $genreDst == 'femme') {
                return (0);
            }
            if ($genreSrc == 'femme' && $genreDst == 'homme') {
                return (0);
            }
        }
        return (10);
    }

    public function getDistance($distance)
    {
        // max dist = 1000km
        return ($distance < 100 ? ($distance * 0.01) * 4 : ($distance * 0.001) * 8);
    }

    public function getTags($src, $dst)
    {
        // max tags = 10.
        $intersection = count(array_intersect($src, $dst));
        return (((10 - $intersection) * 0.1));
    }

    public function getPopularity($src, $dst)
    {
        // on veut le score le moins eleve.
        return (
          (abs($src - $dst) * 0.01) / 1.08
      );
    }
}
