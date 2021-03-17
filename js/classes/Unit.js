class Unit{

    constructor(id) {
        this.id = id;
    }

    setName(){

    }

    getById(){
        return document.getElementById(this.id);
    }

    getByName(num){
        let els = document.getElementsByName(this.id);
        return els[num];
    }

    getByClass(){
        return document.getElementsByClassName(this.id);
    }

    static first(array){
        return array[0];
    }

    static last(array){
        return array[array.length];
    }

    getEltProp(property){
        return this.getById().style.property;
    }

    setEltProp(property, value){
        this.getById().style.property = value;
    }

    showEltProp(property){
        alert(this.getById().style.property);
    }

    getText(){
        return this.getById().innerHTML;
    }

    sayHi() {
        this.getById().alert(this.name);
    }

}

let myElt = new Unit(0);
myElt.getById('dick');
myElt.showEltProp();
