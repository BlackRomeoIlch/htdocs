<?php
/**
 * @copyright Ilch 2
 * @package ilch
 */

namespace Ilch\Config;

class Install extends \Ilch\Mapper
{
    /**
     * @var \Ilch\Translator
     */
    private $translator;

    /**
     * @param \Ilch\Translator $translator
     */
    public function __construct(\Ilch\Translator $translator = null)
    {
        $this->translator = $translator;
        parent::__construct();
    }

    /**
     * @return \Ilch\Translator
     */
    public function getTranslator()
    {
        return $this->translator;
    }
}
