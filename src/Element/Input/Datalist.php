<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form\Element\Input;

use Pop\Dom\Child;

/**
 * Form text element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2015 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0
 */

class Datalist extends Text
{

    /**
     * Datalist object.
     * @var Child
     */
    protected $datalist = null;

    /**
     * Constructor
     *
     * Instantiate the datalist text input form element
     *
     * @param  string $name
     * @param  array  $values
     * @param  string $value
     * @param  string $indent
     * @return Datalist
     */
    public function __construct($name, array $values, $value = null, $indent = null)
    {
        parent::__construct($name, $value, $indent);
        $this->setAttribute('list', $name . '_datalist');

        if (null !== $values) {
            $this->datalist = new Child('datalist', null, null, $this->indent);
            $this->datalist->setAttribute('id', $name . '_datalist');
            foreach ($values as $val) {
                $this->datalist->addChild((new Child('option'))->setAttribute('value', $val));
            }
        }
    }

    /**
     * Render the child and its child nodes
     *
     * @param  boolean $ret
     * @param  int     $depth
     * @param  string  $indent
     * @param  string  $errorIndent
     * @return mixed
     */
    public function render($ret = false, $depth = 0, $indent = null, $errorIndent = null)
    {
        $datalist = parent::render(true, $depth, $indent) . $this->datalist->render(true, $depth, $indent);

        // Return or print the rendered child node output.
        if ($ret) {
            return $datalist;
        } else {
            echo $datalist;
        }
    }

}
