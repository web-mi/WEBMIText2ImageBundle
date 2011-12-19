<?php

namespace WEBMI\Text2ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;

class IndexController extends Controller
{
    /**
     * @Route("/text2image/{param}", name="ioformbundle_ajax_choice", requirements={"_format" = "json"}, defaults={"_format" = "json"})
     */
    public function indexAction()
    {
        // Text
        $text = "Fernsehen";

        // Breite und Hoehe der Grafik (in Pixel)
        $grafik = imagecreatetruecolor(180,30);

        // Farben definieren
        // Schriftfarbe R-G-B
        $schriftfarbe = ImageColorAllocate($grafik,102,102,102);

        // Hintergrundfarbe R-G-B
        $hintergrund = ImageColorAllocate($grafik,255,255,255);

        // Schattenfarbe
        $shadow = imagecolorallocate($grafik, 128, 128, 128);

        // Arbeitsflaeche auf der Grafik: Von X=0/Y=0 bis X=180/Y=30
        ImageFilledRectangle($grafik, 0, 0, 180, 30, $hintergrund);

        //Zu verwendende Font
        $font = 'DroidSans-Bold.ttf';

        //Fügt einen Text Schatten in die Grafik
        //erste fünf Parameter wie bei imagettftext
        // @param string $font im format .ttf
        // @param string $text
        // @param int Auslauf wie weit der Schatten ausläuft um die Schrift
        // @param $shadow imagecolorallocate(RGB) Farbe von der der Schattenverlauf anfängt
        // @param $hintergrund imagecolorallocate(RGB) Farbe in die der Schatten ausläuft
        // @param int 0-360° Richtung des Schattenfalls
        imagettfshadow($grafik, 20, 0, 10, 20, $font, $text, 5, $shadow, $hintergrund, 215);

        //Setzt den einzufügenden Text in die Grafik
        imagettftext($grafik, 20, 0, 10, 20, $schriftfarbe, $font, $text);

        // Hintergrundfarbe transparent
        imagecolortransparent( $grafik, $hintergrund );

        //dreht die Grafik um 90°
        $grafik = imagerotate($grafik, 90, 0);

        //Setzt den Header auf PNG und gibt das PNG aus
        Header("Expires: Mon, 20 Mar 2002 02:38:00 GMT");
        Header("Content-type: image/png");
        ImagePNG($grafik);
        ImageDestroy($grafik);
    }
    
    /**
     *
     * @param type $im
     * @param type $size
     * @param type $angle
     * @param type $x
     * @param type $y
     * @param string $font
     * @param string $text
     * @param int $width
     * @param type $frcolor
     * @param type $bgcolor
     * @param int $degree 
     */
    private function imagettfshadow($im, $size, $angle, $x, $y, $font, $text, $width, $frcolor, $bgcolor=false, $degree=315)
    {
        $frcolor =imagecolorsforindex($im, $frcolor);
	// gradient
	if ($bgcolor !== false) {
            // trouble shooting
            if ($width == 1) {
                $width = 2;
            }
            $bgcolor =imagecolorsforindex($im, $bgcolor);
            $steps = array(
                'red' => ($frcolor['red'] - $bgcolor['red']) / ($width-1),
                'green' => ($frcolor['green'] - $bgcolor['green']) / ($width-1),
		'blue' => ($frcolor['blue'] - $bgcolor['blue']) / ($width-1)
            );
	} else {
            $bgcolor = $frcolor;
	}
	// display shadow
	$cos = cos(deg2rad($degree));
	$sin = sin(deg2rad($degree));
	$x = $x + $width * $cos;
	$y = $y - $width * $sin;
	for ($i = 0; $i < $width; $i++) {
            $x -= $cos;
            $y += $sin;
            imagettftext($im, $size, $angle, round($x), round($y), imagecolorallocate($im, $bgcolor['red'], $bgcolor['green'], $bgcolor['blue']), $font, $text);
            $bgcolor = array(
                'red' => $bgcolor['red'] + $steps['red'],
		'green' => $bgcolor['green'] + $steps['green'],
		'blue' => $bgcolor['blue'] + $steps['blue'],
            );
	}
    }
    
}
