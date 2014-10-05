var extern = function (scope,symbol, callback) {
    this._value = 0;
    this._scope= scope;
    this._symbol = symbol;
    this._callback = callback;
    this._oldValue;
    this._ignore=extern.prototype.ignoreFirstUpdate;

    this.value = function () {

        if (extern.prototype.mode == "sync") {
            multifetch({
                url: extern.prototype.path + "read.php?scope=" + this._scope+"&symbol=" + this._symbol,
                context: this,
                async: false,
                success: function (data) {

                    if (data != "")
                        this._value = data;
                    

                }

            });




        }
        return this._value;

    }


    this.update = function () {

if(extern.prototype.mode=="async") {


        multifetch({
            url: extern.prototype.path + "read.php?scope=" + this._scope+"&symbol=" + this._symbol,
            context: this,
            success: function (data) {

                if (data != "")
                    this._value = data;
                else
                    this._value = "undefined";



                if (this._value != this._oldValue) {

                    this._oldValue = this._value;
			if(this._ignore==true){
				this._ignore=false;
				return;

			}
                   this._callback();

                }
            }

        });

};

    }
};




extern.prototype.path = "/extern/";
extern.prototype.mode = "async";
extern.prototype.ignoreFirstUpdate=true;
