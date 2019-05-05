<?php
namespace NatribuNext;
require 'plates-minify.php';
use League\Plates\{Engine as PlatesEngine, Extension\ExtensionInterface};
use u45Green\PlatesM2Minify as PlatesMinify;
use Exception;

class Engine {
    //const DEBUG = true;
    private $engine;
    public $locales;

    public function render(string $pageId, string $localeId): string {
        if(empty($this->locales[$localeId])){
            throw new Exception("Locale \"$localeId\" not found");
        }
        if(empty($this->locales[$localeId][$pageId])){
            throw new Exception("Page \"$pageId\" not found");
        }
        $result = $this->engine->render($pageId, array_merge(
            $this->locales[$localeId][$pageId],
            $this->locales[$localeId]
        ));
        return preg_replace("/[\n\r\t]|\s{4,}/", "", $result);
    }

    public function localeSelectList(): array {
        if(isset($this->localeList)) return $this->localeList;
        $list = [];
        foreach($this->locales as $id=>$locale){
            $meta = $locale['__meta__'];
            $list[$meta['group']] = $list[$meta['group']] ?? [];
            $list[$meta['group']][$id] = $locale['__meta__']['name'];
        }
        $this->localeList = $list;
        return $list;
    }

    public function __construct() {
        $engine = new PlatesEngine('./view/', 'phtml');
        $engine->registerFunction('localeSelectList', [$this, 'localeSelectList']);
        $engine->loadExtension(new PlatesMinify());
        $this->locales = [];
        foreach(glob('locales/*.json') as $file){
            preg_match("/([A-z0-9]+)\.json/", $file, $id);
            if(!$id) continue;
            $this->locales[$id[1]] = json_decode(file_get_contents($file), true);
            $this->locales[$id[1]]['__meta__']['locale'] = $id[1];
        }
        $this->engine = $engine;
    }
}
?>
