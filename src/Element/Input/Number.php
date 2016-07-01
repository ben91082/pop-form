<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp-framework
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form\Element\Input;

use Pop\Form\Element;

/**
 * Form number element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.1.0
 */

class Number extends Element\Input
{

    /**
     * Constructor
     *
     * Instantiate the number input form element
     *
     * @param  string $name
     * @param  int    $min
     * @param  int    $max
     * @param  string $value
     * @param  string $indent
     * @return \Pop\Form\Element\Input\Number
     */
    public function __construct($name, $min, $max, $value = null, $indent = null)
    {
        parent::__construct($name, 'number', $value, $indent);
        $this->setAttributes([
            'min' => $min,
            'max' => $max
        ]);
    }

}
