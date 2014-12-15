<?php
/**
 * Pop PHP Framework (http://www.popphp.org/)
 *
 * @link       https://github.com/popphp/popphp
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2014 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Form\Element\Input;

/**
 * Form submit element class
 *
 * @category   Pop
 * @package    Pop_Form
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2014 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.popphp.org/license     New BSD License
 * @version    2.0.0a
 */

class Submit extends AbstractInput
{

    /**
     * Element attributes
     * @var array
     */
    protected $attributes = ['type' => 'submit'];

    /**
     * Constructor
     *
     * Instantiate the submit input form element
     *
     * @param  string $name
     * @param  string $value
     * @param  string $indent
     * @return Submit
     */
    public function __construct($name, $value = null, $indent = null)
    {
        parent::__construct($name, $value, $indent);
        $this->setAttributes(['name' => $name, 'id' => $name, 'value' => $value]);
    }

}