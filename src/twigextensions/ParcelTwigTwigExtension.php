<?php
/**
 * ParcelTwig plugin for Craft CMS 3.x
 *
 * Get correct asset paths from Parcel when using Parcel Manifest.
 *
 * @link      kult.design
 * @copyright Copyright (c) 2020 Sigurd Heggemsnes
 */

namespace heggemsnes\parceltwig\twigextensions;

use heggemsnes\parceltwig\ParcelTwig;

use Craft;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Twig can be extended in many ways; you can add extra tags, filters, tests, operators,
 * global variables, and functions. You can even extend the parser itself with
 * node visitors.
 *
 * http://twig.sensiolabs.org/doc/advanced.html
 *
 * @author    Sigurd Heggemsnes
 * @package   ParcelTwig
 * @since     1.0.0
 */
class ParcelTwigTwigExtension extends AbstractExtension
{


    private $_settings;
    public static $__manifest__ = false;

    // Public Methods
    // =========================================================================

   /*  public function __construct(){
        $self::$settings = \heggemsnes\parceltwig\ParcelTwig::getInstance()->getSettings();
        $self::$manifest_path = $settings->manifestPath;
        $self::dist_path = $settings->distPath;
    } */

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'ParcelTwig';
    }

    /**
     * Returns an array of Twig functions, used in Twig templates via:
     *
     *      {% set this = someFunction('something') %}
     *
    * @return array
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('asset', [$this, 'getManifestAssetPath']),
        ];
    }

    /**
     * Use Parcel asset manifest in order to get correct asset path.
     *
     * @param string $handle
     *
     * @return string
     */
    public function getManifestAssetPath($handle)
    {   


        $this->getSettings();
        $manifest_path = $this->_settings['manifestPath'];
        $dist_path = $this->_settings['distPath'];
        if(self::$__manifest__ === false){
            if(file_exists($manifest_path)){
                self::$__manifest__ = json_decode(file_get_contents($manifest_path), true);
            }else{
                self::$__manifest__ = null;
            }
        }
        

        // Manifest not found
        if (self::$__manifest__ === null) {
            trigger_error("Could not load manifest file", E_USER_WARNING);
            return;
        }

        // Handle not found in manifest
        if (!isset(self::$__manifest__[$handle])) {
            trigger_error("{$handle} is not defined as an asset", E_USER_WARNING);
            return;
        }
        
        $uri =  $dist_path . "/" . self::$__manifest__[$handle];
        if (preg_match('/\.js$/i', $uri)) {
            $out = "<script src='" . $uri . "'></script>";
            return new \Twig_Markup( $out, 'UTF-8' );
        } elseif (preg_match('/\.css$/i', $uri)) {
            $out =  "<link href='" . $uri . "' rel='stylesheet'/>";
            return new \Twig_Markup( $out, 'UTF-8' );
        } else {
            trigger_error("File didn't match .js or .css for {$handle}" );
            return;
        }
    }

    private function getSettings(){
        $this->_settings = \heggemsnes\parceltwig\ParcelTwig::getInstance()->getSettings();
    }
}
