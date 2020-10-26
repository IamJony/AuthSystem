<?php

declare(strict_types = 1);
namespace Login\Form;
use Login\Form\{ModalForm,Form,CustomForm,SimpleForm};
trait FormUI {



    /**
     * @deprecated
     *
     * @param callable $function
     * @return CustomForm
     */
    public function createCustomFor(callable $function = null) : CustomForm {
        return new CustomForm($function);
    }

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return SimpleForm
     */
    public function createSimpleFor(callable $function = null) : SimpleForm {
        return new SimpleForm($function);
    }

    /**
     * @deprecated
     *
     * @param callable|null $function
     * @return ModalForm
     */
    public function createModalFor(callable $function = null) : ModalForm {
        return new ModalForm($function);
    }
}
