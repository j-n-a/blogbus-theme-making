/**
 * @author Jack Yin
 * @version 2009-6-2 11:07
 * @param fatherId
 * @param eleName All the children with this tag name will be affected.
                  <strong>Use upper cases</strong> to avoid issues.
 * @param oddClassName
 * @param evenClassName
 */
function changeEvenStyle(fatherId, eleName, oddClassName, evenClassName) {
    var parObj = document.getElementById(fatherId);
    var obj = parObj.firstChild;

    // set default element name
    if (eleName == null || eleName == "") {
        eleName = "LI";
    }

    var i = 0;
    while (obj != null) {
        if(obj.nodeName != null && obj.nodeName == eleName) {
            obj.className = i % 2 == 0
                ? obj.className + " " + oddClassName
                : obj.className + " " + evenClassName;
            i++;
        }
        obj = obj.nextSibling;
    }
}
