<?php

namespace WEBMI\Bundle\Text2ImageBundle\Twig\Extension;

use WEBMI\Bundle\Text2ImageBundle\Helper\Text2ImageHelper;
use Symfony\Component\Config\FileLocator;

class Text2ImageTwigExtension extends \Twig_Extension
{
     public function __constructor() {
        print_r(func_get_args());exit;
    }
    
     public function getFilters() {
        return array(
            'var_dump'   => new \Twig_Filter_Function('var_dump'),
            'highlight'  => new \Twig_Filter_Method($this, 'highlight'),
            'text2image'  => new \Twig_Filter_Method($this, 'text2image'),
        );
    }

    public function highlight($sentence, $expr) {
        return preg_replace('/(' . $expr . ')/', '<span style="color:red">\1</span>', $sentence);
    }
    
    public function text2image($sentence, $expr) {
        //return preg_replace('/(' . $expr . ')/', '<span style="color:red">\1</span>', $sentence);
        
        // Text
        $text = $sentence;

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
        $font_locator = new FileLocator(__DIR__.'/../../Resources/public/fonts/');
        try {
                $font = $font_locator->locate('DroidSans-Bold.ttf');
        } catch (\InvalidArgumentException $e) {
                $font = $font_locator->locate('DroidSans-Bold.ttf');
        }
        
        //Fügt einen Text Schatten in die Grafik
        $this->imagettfshadow($grafik, 20, 0, 10, 20, $font, $text, 5, $shadow, $hintergrund, 215);

        //Setzt den einzufügenden Text in die Grafik
        imagettftext($grafik, 20, 0, 10, 20, $schriftfarbe, $font, $text);

        // Hintergrundfarbe transparent
        imagecolortransparent( $grafik, $hintergrund );

        //dreht die Grafik um 90°
        $grafik = imagerotate($grafik, 90, 0);

        //Setzt den Header auf PNG und gibt das PNG aus
        $header['expires']='Expires: Mon, 20 Mar 2002 02:38:00 GMT';
        $header['content-type']='Content-type: image/png';
        //Setzt den Header auf PNG und gibt das PNG aus
        //Header("Expires: Mon, 20 Mar 2002 02:38:00 GMT");
        //Header("Content-type: image/png");
        $binaryPic = ImagePNG($grafik);
        ImageDestroy($grafik);
        $this->get('my_templating')->render('WEBMIText2ImageBundle:Default:imageReturnTemplate.html.twig', array('header' => $header, 'binaryPic' => $binaryPic));
        //return $templating->render('WEBMIText2ImageBundle:Default:imageReturnTemplate.html.twig', array('header' => $header, 'binaryPic' => $binaryPic));
        
    }

    public function getName()
    {
        return 'my_twig_extension';
    }
    
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
