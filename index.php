<?php
interface Basis {

    public function ability();

}

abstract class Vehicle implements basis {
    //constructor
    private string $name;
    private string $type;

    public function __construct(string $name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    //engine status
    protected bool $engine = false;



    //oil volume
    protected int $gasTank = 100;

    //refill gas tank
    protected function refill() {
        if ($this->engine == true) {
            echo "STOP THE ENGINE!\n";
        } else {
            echo "GAS TANK is FULL!";
            return $this->gasTank = 100;

        }

    }

    //switcher
    static protected function switcher(&$tool):bool {
        if ($tool == false){
            return $tool = true;
        } else {
            return $tool = false;
        }
    }

    //SWITCH ON/OFF ENGINE
    protected function switchEngine() {
        $this->switcher($this->engine);
        echo ($this->engine == true)? "$this->name is LAUNCHED\n":"$this->name is STOPPED\n\n";
    }

    //START MOVE
    public function startMove(int $consumption=1, $rotation=1, $time=5) {
        if ($this->engine == true) {
            $i = 0;
            while($i <= $time) {
                if( $this->gasTank <= 0) {
                    $this->switchEngine();
                    echo "OUT OF GAS!\n";
                    $this->refill();
                    break;
                } else {
                    sleep($rotation);
                    $this->gasTank = $this->gasTank - $consumption;
                    echo "motion; oil: $this->gasTank\n";
                    $i++;
                }

            }
            echo "STOP!\n";
        } else {
            $this->switchEngine();
            $this->startMove();
        }
    }
}

//CLASS CAR
class Car extends Vehicle {

    protected string $color ;

    public function __construct(string $name, $type, $color)
    {
        parent::__construct($name, $type);
        $this-> color = $color;
    }

    //NO2 make it BRRRRRR!
    public function ability() {

        $this->startMove(3, 0.2);
        echo "THE ENGINE IS OVERHEATED!\n";
        $this->switchEngine();




    }

    //beeeep
    public function signal():void {
        echo "BEEEEEEP \n";
    }

    //CAR WIPERS method
    public function carWipers ():void {
        $i = 0;
        while ($i < 4) {
            sleep (1);
            echo '*whoosh*';
        }
        echo 'window clear';
    }

};

//CLASS BULLDOZER
class Bulldozer extends Vehicle {


    protected bool $blade = false;

    protected int $consumption = 2;
    protected float $rotation = 1;

    //BLADE manage
    public function bladeSwitch(){
        $this->switcher($this->blade);
        if ($this->blade == true) {
            echo "BLADE is DOWN!\n";
            $this->consumption = 5;
            $this->rotation=2;
        }   else {
            echo "BLADE is UP!\n";
            $this->consumption = 2;
            $this->rotation = 1;
        }
    }

    //WORK method
    public function ability(){
        $this->switchEngine();
        echo "START WORKING\n";
        if ($this->blade==false) {$this->bladeSwitch();}
        $this->startMove($this->consumption, $this->rotation, 4);
        $this->bladeSwitch();
        $this->startMove($this->consumption, $this->rotation, 4);
        $this->bladeSwitch();
        echo "STOP WORKING\n";


    }
}

//FUNCTION

function makeItWork ($object) {
    $object->ability();
};


//test

$chevy = new Car('Chevrolet Camaro 1969 RS/SS', 'sport', 'Black with white stripes');

makeItWork($chevy);

$bigBoy = new Bulldozer('Big Boy', 'Special');

makeItWork($bigBoy);

