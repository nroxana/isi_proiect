function clone(src, deep) {

    var toString = Object.prototype.toString;
    if(!src && typeof src != "object"){
        //any non-object ( Boolean, String, Number ), null, undefined, NaN
        return src;
    }

    //Honor native/custom clone methods
    if(src.clone && toString.call(src.clone) == "[object Function]"){
        return src.clone(deep);
    }

    //DOM Elements
    if(src.nodeType && toString.call(src.cloneNode) == "[object Function]"){
        return src.cloneNode(deep);
    }

    //Date
    if(toString.call(src) == "[object Date]"){
        return new Date(src.getTime());
    }

    //RegExp
    if(toString.call(src) == "[object RegExp]"){
        return new RegExp(src);
    }

    //Function
    if(toString.call(src) == "[object Function]"){
        //Wrap in another method to make sure == is not true;
        //Note: Huge performance issue due to closures, comment this :)
        return (function(){
            src.apply(this, arguments);
        });

    }

    var ret, index;
    //Array
    if(toString.call(src) == "[object Array]"){
        //[].slice(0) would soft clone
        ret = src.slice();
        if(deep){
            index = ret.length;
            while(index--){
                ret[index] = clone(ret[index], true);
            }
        }
    }
    //Object
    else {
        ret = src.constructor ? new src.constructor() : {};
        for (var prop in src) {
            ret[prop] = deep
                ? clone(src[prop], true)
                : src[prop];
        }
    }

    return ret;
};

var tableToExcel = (function() {
      var uri = 'data:application/vnd.ms-excel;base64,'
        , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
        , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
        , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
      return function(table) {
        if (!table.nodeType) 
            table = document.getElementById(table)
        var newTable = clone(table, true);
        newTable.deleteRow(newTable.rows.length - 1);
        var ctx = {worksheet: 'Worksheet', table: newTable.innerHTML}
        window.location.href = uri + base64(format(template, ctx))
      }
    })()