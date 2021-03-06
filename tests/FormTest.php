<?php

namespace Pop\Form\Test;

use Pop\Form\Form;
use Pop\Form\Element;

class FormTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $username = new Element\Input('username');
        $email    = new Element\Input\Email('email');
        $submit   = new Element\Input\Submit('submit', 'SUBMIT');
        $form = new Form([$username, $email, $submit], '/process', 'post');
        $this->assertInstanceOf('Pop\Form\Form', $form);
        $this->assertInstanceOf('Pop\Form\Element\AbstractElement', $form->getField('username'));
        $this->assertEquals('/process', $form->getAction());
        $this->assertEquals('post', $form->getMethod());
    }

    public function testCreateFromConfig()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'file' => [
                'type'  => 'file',
                'label' => 'File:'
            ]
        ]);
        $form->addFieldFromConfig('submit', [
            'type'  => 'submit',
            'value' => 'SUBMIT'
        ]);
        $this->assertInstanceOf('Pop\Form\Form', $form);
        $this->assertEquals(3, count($form->getFields()));
    }

    public function testCreateFromFieldsetConfig()
    {
        $form = Form::createFromFieldsetConfig([
            [
                'username' => [
                    'type'     => 'text',
                    'label'    => 'Username:',
                    'required' => true
                ],
                'file' => [
                    'type'  => 'file',
                    'label' => 'File:'
                ]
            ],
            [
                'submit' => [
                    'type'  => 'submit',
                    'value' => 'SUBMIT'

                ]
            ]
        ]);
        $this->assertInstanceOf('Pop\Form\Form', $form);
        $this->assertEquals(3, count($form->getFields()));
    }

    public function testCreateAndRemoveFieldset()
    {
        $form = new Form();
        $form->createFieldset('Fieldset 1', 'table');
        $this->assertEquals('Fieldset 1', $form->getFieldset()->getLegend());
        $form->setLegend('Fieldset 1 Rev');
        $this->assertEquals('Fieldset 1 Rev', $form->getLegend());
        $this->assertEquals('table', $form->getFieldset()->getContainer());
        $form->createFieldset('Fieldset 2');
        $form->removeFieldset(1);
        $form->setCurrent(0);
        $this->assertEquals(0, $form->getCurrent());
    }

    public function testInsertAfter()
    {
        $username = new Element\Input('username');
        $submit   = new Element\Input\Submit('submit', 'SUBMIT');
        $form = new Form([$username, $submit]);
        $form->insertFieldAfter('username', new Element\Input\Email('email'));
        $this->assertEquals(3, count($form->getFields()));
    }

    public function testInsertBefore()
    {
        $username = new Element\Input('username');
        $submit   = new Element\Input\Submit('submit', 'SUBMIT');
        $form = new Form([$username, $submit]);
        $form->insertFieldBefore('submit', new Element\Input\Email('email'));
        $this->assertEquals(3, $form->count());
    }

    public function testToArray()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $this->assertEquals(3, count($form->toArray()));
    }

    public function testIterator()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $i = 0;
        foreach ($form as $key => $value) {
            $i++;
        }

        $this->assertEquals(3, $i);
    }

    public function testAddFilter()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $form->addFilter('htmlentities', [ENT_QUOTES, 'UTF-8']);
        $form->addFilter('strip_tags', null, 'email', 'email');
        $form->setFieldValues(['username' => '<h1>admin</h1>', 'email' => 'admin@admin.com']);
        $this->assertEquals('&lt;h1&gt;admin&lt;/h1&gt;', $form->username);
        $form->clearFilters();
    }

    public function testAddColumn()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ]
        ],
            [
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ]
        ],
        [
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $form->addColumn([1, 2], 'left-column');
        $form->addColumn(3,'right-column');
        $this->assertTrue($form->hasColumn('left-column'));
        $this->assertEquals(2, count($form->getColumn('left-column')));
        $form->removeColumn('right-column');
        $this->assertFalse($form->hasColumn('right-column'));
    }

    public function testIsValid()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $form->setFieldValues(['email' => 'admin@admin.com']);
        $this->assertFalse($form->isValid());
        $this->assertEquals(1, count($form->getErrors('username')));
        $this->assertEquals(1, count($form->getAllErrors()));
        $form->reset();
    }

    public function testToString()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        ob_start();
        echo $form;
        $result = ob_get_clean();

        $this->assertContains('<form', $result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testClear()
    {
        $form = Form::createFromConfig([
            'username' => [
                'type'     => 'text',
                'label'    => 'Username:',
                'required' => true
            ],
            'email' => [
                'type'  => 'email',
                'label' => 'Email:'
            ],
            'submit' => [
                'type'  => 'submit',
                'value' => 'SUBMIT'
            ]
        ]);
        $form->clearTokens();
    }

}
