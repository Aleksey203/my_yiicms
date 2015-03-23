
<?php
class MyClass
{
    protected function myFunc() {
        echo "MyClass::myFunc()\n";
    }
}

class OtherClass extends MyClass
{
    // Перекрываем родительское определение
    public function myFunc()
    {
        // Но все еще вызываем родительскую функцию
        parent::myFunc();
        echo "OtherClass::myFunc()\n";
    }
}

//$class = new OtherClass();
OtherClass::myFunc();
?>
