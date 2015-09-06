function Form(name, lastname){
    
    this.getText = function(){return name};
    this.setText = function(text){name = text};
    
    
    this.getText = function(){return lastname};
    this.setText = function(text){lastname = text};
    
}