<?php
/**
 * MatthiasMullie's Minify extension for Plates (PlatesM2Minify)
 * Also no need to write own style/script tags
 * @example <?=$this->m2Minify()->CSS("filename.css")?>
 * @example <?=$this->m2Minify()->JS("filename.js")?>
 * @example <?=$this->m2MinifyCSS($this->section('style'))?>
 * @example <?=$this->m2MinifyJS($this->section('script'))?>
 * @license MIT
 */
namespace u45Green;
use MatthiasMullie\Minify\{CSS, JS};
use League\Plates\{Engine, Extension\ExtensionInterface};

class PlatesM2Minify implements ExtensionInterface {
    /* Constants */
    const DO_NOT_POLLUTE = 1;
    
    private $flags = 0;
    protected $cssMinifier;
    protected $jsMinifier;
    
    /**
     * @constructor
     * 
     * Constructor flags:
     * - DO_NOT_POLLUTE - Do not define any other function except $this->m2Minify();
     * @param string|int|null Flags described above
     */
    public function __construct($flags = 0) {
        $this->cssMinifier = new CSS();
        $this->jsMinifier = new JS();

        if(is_callable($flags)) $flags = $flags();
        if(is_string($flags)) $flags = explode("|", $flags);
        if(is_array($flags)) $flags = array_reduce($flags, function($p, $v) {
            return $p + (isset(self::$v) ? self::$v : 0);
        }, 0);
        if(is_int($flags)) $this->flags = $flags;
    }

    /**
     * Register
     */
    public function register(Engine $engine) {
        $engine->registerFunction('m2Minify', [$this, '_this']);
        if(!($this->flags & self::DO_NOT_POLLUTE)) {
            $engine->registerFunction('m2MinifyCSS', [$this, 'css']);
            $engine->registerFunction('m2MinifyJS', [$this, 'js']);
        }
    }

    /**
     * Primary function
     * @example <?=$this->m2Minify()->[method()]?>
     */
    public function _this(): self {
        return $this;
    }

    /**
     * Inline minified CSS from content
     * @param string Filename or CSS content
     */
    public function css(string $source): string {
        $this->cssMinifier->add($source);
        $content = $this->cssMinifier->minify();
        return $content ? "<style type=\"text/css\">$content</style>" : "";
    }

    /**
     * Inline minified JS from content
     * @param string Filename or JS content
     */
    public function js(string $source): string {
        $this->jsMinifier->add($source);
        $content = $this->jsMinifier->minify();
        return $content ? "<script type=\"text/javascript\">$content</script>" : "";
    }
}
?>