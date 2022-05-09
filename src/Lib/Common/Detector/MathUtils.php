<?php

namespace QrCodeReader\Lib\Common\Detector;

final class MathUtils {

    private function __construct() {

    }

    /**
     * Ends up being a bit faster than {@link Math#round(float)}. This merely rounds its
     * argument to the nearest int, where x.5 rounds up to x+1. Semantics of this shortcut
     * differ slightly from {@link Math#round(float)} in that half rounds down for negative
     * values. -2.5 rounds to -3, not -2. For purposes here it makes no difference.
     *
     * @param d real value to round
     * @return nearest {@code int}
     */
    public static function round($d) {
        return (int) ($d + ($d < 0.0 ? -0.5 : 0.5));
    }

    public static function distance($aX, $aY, $bX, $bY) {
        $xDiff = $aX - $bX;
        $yDiff = $aY - $bY;
        return (float) sqrt($xDiff * $xDiff + $yDiff * $yDiff);
    }


}
