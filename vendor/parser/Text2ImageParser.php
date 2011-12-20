<?php

/**
 * Text2Image parser provides basic text2image syntax as described here http://daringfireball.net/projects/markdown/syntax
 */
class Text2ImageParser
{
    
    private $grafik;
    private $fColor;
    private $bgColor;
    private $sColor;
    
    public function __construct()
    {
    }

    public function transform($text)
    {
        #
        # Main function. Performs some preprocessing on the input text
        # and pass it through the document gamut.
        #
        $this->setup(180, 30);

        // Arbeitsflaeche auf der Grafik: Von X=0/Y=0 bis X=180/Y=30
        ImageFilledRectangle($grafik, 0, 0, 180, 30, $hintergrund);

        //Zu verwendende Font
        $font = 'DroidSans-Bold.ttf';

        $this->imagettfshadow($grafik, 20, 0, 10, 20, $font, $text, 5, $shadow, $hintergrund, 215);

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

        return $grafik."\n";
    }

    protected function setup($width = 200, $height = 200)
    {
        // Breite und Hoehe der Grafik (in Pixel)
        $this->grafik = imagecreatetruecolor($width,$height);
        
        $this->prepareFontColor();
        
        $this->prepareShadowColor();
        
    }

    protected function prepareFontColor()
    {
        // Farben definieren
        // Schriftfarbe R-G-B
        $fColor = ImageColorAllocate($this->grafik,102,102,102);
    }

    protected function prepareBackgroundColor()
    {
        // Hintergrundfarbe R-G-B
        $bgColor = ImageColorAllocate($this->grafik,255,255,255);
    }
    
    protected function prepareShadowColor()
    {
        // Schattenfarbe
        $sColor = imagecolorallocate($this->grafik, 128, 128, 128);
    }
    
    /**
     *
     * @param type $im
     * @param type $size
     * @param type $angle
     * @param type $x
     * @param type $y
     * @param type $font
     * @param type $text
     * @param int $width
     * @param type $frcolor
     * @param type $bgcolor
     * @param type $degree 
     */
    protected function imagettfshadow($im, $size, $angle, $x, $y, $font, $text, $width, $frcolor, $bgcolor=false, $degree=315)
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
    
    protected function doImages($text)
    {
    }

    protected function prepareItalicsAndBold()
    {


    }
}