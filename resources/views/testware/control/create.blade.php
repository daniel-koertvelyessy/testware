@extends('layout.layout-main')

@section('mainSection', 'testWare')

@section('menu')
    @include('menus._menu_testware_main')
@endsection

@section('modals')
    <div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" id="signatureModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="messWertDialog">Unterschrift <span id="sigHead"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="wrapper">
                        <canvas id="signatureField" class="signature-pad" ></canvas>
                        <input type="hidden" name="signatureType" id="signatureType" value="">
                    </div>
                    <label for="signaturName" class="sr-only">Name des Unterschreibenden</label>
                    <input type="text" name="signaturName" id="signaturName" placeholder="Name des Unterscheibenden" class="form-control">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-warning btn-sm" id="btnClearCanvas">Neu</button>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="btnSignZuruck">Zurück</button>
                    <button type="button" class="btn btn-primary btn-sm" id="btnStoreSignature">speichern</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <div class="container">
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3">{{__('Prüfung erfassen')}}</h1>
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <h2 class="h5">Prüfaufgabe: {{ $controlItem->Anforderung->an_name_lang }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h2 class="h5">Kopfdaten</h2>
                <div class="row">
                    <div class="col-md-6">
                        <x-staticfield id="controlUserName"
                                       label="Prüfer"
                                       value="{{ auth()->user()->name }}"
                        />
                        <input type="hidden"
                               name="control_user_id"
                               id="control_user_id"
                               value="{{ auth()->user()->id }}"
                        >
                    </div>
                    <div class="col-md-6">
                        <x-datepicker id="controlDate"
                                      label="Datum"
                                      value="{{ date('Y-m-d') }}"
                        />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="h5">Verwendete Prüfmittel</h2>
                <x-selectgroup
                    id="set_control_equipment"
                    label="Prüfmittel wählen"
                    btnL="hinzufügen"
                    class="btnAddControlEquipmentToList"
                >
                    @forelse (App\Equipment::getControlEquipmentList() as $controlProdukt)
                        @if($controlProdukt->qe_control_date_due > now())
                            <option value="{{ $controlProdukt->id }}">{{ $controlProdukt->prod_name_kurz.' - '. $controlProdukt->eq_inventar_nr }}</option>
                        @else
                            <option value="{{ $controlProdukt->id }}"
                                    disabled
                            >{{ $controlProdukt->prod_name_kurz.' - '. $controlProdukt->eq_inventar_nr }} Prüfung überfällig!
                            </option>
                        @endif
                    @empty
                        <option value="void"
                                selected
                                disabled
                        >Keine Prüfmittel gefunden
                        </option>
                    @endforelse
                </x-selectgroup>

                <ul class="list-group mt-3"
                    id="ControlEquipmentToList"
                >

                </ul>


            </div>
        </div>

        <h2 class="h4 mt-5 mb-2">Voränge</h2>
        <div class="row">
            <div class="col">
                <table class="table table-borderless">

                    @forelse (App\AnforderungControlItem::where('anforderung_id',$controlItem->anforderung_id)->get() as $aci)
                        @if($aci->aci_contact_id === auth()->user()->id)
                            <tr>
                                <td colspan="4"
                                    class="m-0 p-0"
                                >
                                    <span class="lead">{{ $aci->aci_name_lang }}</span>
                                    <div class="dropdown d-md-none">
                                        <button class="btn btn-sm btn-outline-primary"
                                                data-toggle="collapse"
                                                data-target="#taskDetails_{{ $aci->id }}"
                                                role="button"
                                                aria-expanded="false"
                                                aria-controls="taskDetails_{{ $aci->id }}"
                                        >
                                            Details
                                        </button>

                                        <div class="collapse"
                                             id="taskDetails_{{ $aci->id }}"
                                        >
                                            {{ $aci->aci_task }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th scope="col"
                                    class="d-none d-md-table-cell"
                                >Aufgabe
                                </th>
                                <th scope="col"
                                    style="min-width: 95px;"
                                >Soll
                                </th>
                                <th scope="col">Ist</th>
                                <th scope="col">Bestanden</th>
                            </tr>
                            <tr>
                                <td class="d-none d-md-table-cell">{{ $aci->aci_task }}</td>
                                <td>
                                    @if($aci->aci_vaule_soll !== null)
                                        <strong>{{ $aci->aci_vaule_soll }}</strong> {{ $aci->aci_value_si }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td style="min-width: 95px;">
                                    @if($aci->aci_vaule_soll !== null)
                                        <label for="aci_read_{{ $aci->id }}"
                                               class="sr-only"
                                        >Ist-Wert</label>
                                        <input type="text"
                                               placeholder="Wert"
                                               class="form-control"
                                               id="aci_read_{{ $aci->id }}"
                                               name="aci_read[]"
                                        >
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-toggle"
                                         data-toggle="buttons"
                                    >
                                        <label class="btn btn-outline-success active">
                                            <input type="radio"
                                                  id="aci_Passed_{{ $aci->id }}"
                                                  name="aci_passed[{{ $aci->id }}]"

                                            > JA </label>
                                        <label class="btn btn-outline-danger">
                                            <input type="radio" id="aci_notPassed_{{ $aci->id }}"
                                                   name="aci_passed[{{ $aci->id }}]"
                                            > NEIN </label>
                                    </div>

                                </td>
                            </tr>
                            @if (!$loop->last)
                                <tr>
                                    <td colspan="4"
                                        class="m-0 p-0"
                                    >
                                        <div class="dropdown-divider"></div>
                                    </td>
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td>
                                    <p>Zum Ausführen des Vorgangs <span class="badge-info p-2">{{ $aci->aci_name_lang }}</span> fehlt Ihnen die benötige Berechtigung!</p>
                                    <p>Brechtigt sind: {{ App\User::with('profile')->find($aci->aci_contact_id)->name }}</p>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td>
                                <x-notifyer>Es sind keine Vorgänge zu diesem Gerät gefunden worden!</x-notifyer>
                            </td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="lead">Unterschriften</p>
                <div class="card-group">
                    <div class="card">
                        <img src="" class="card-img-top img-thumbnail d-none" alt="Unterschriftbild Prüfer" id="imgSignaturePruefer" style="width:265px; height:200px">
                        <div class="card-body">
                            <input type="hidden" name="signaturPrueferID" id="signaturPrueferID">
                            <button type="button" class="btn btn-outline-primary btnAddSiganture" data-toggle="modal" data-target="#signatureModal" data-sig="pruef"><i class="fas fa-signature"></i> Unterschrift Prüfer</button>
                        </div>
                    </div>
                    <div class="card">
                        <img src="" class="card-img-top img-thumbnail d-none" alt="Unterschriftbild Leitung" id="imgSignatureLeitung" style="width:265px; height:200px">
                        <div class="card-body">
                            <input type="hidden" name="signaturLeitungID" id="signaturLeitungID">
                            <button type="button" class="btn btn-outline-primary btnAddSiganture" data-toggle="modal" data-target="#signatureModal" data-sig="leit"><i class="fas fa-signature"></i> Unterschrift Leitung</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row my-4">
            <div class="col">
                <h2 class="h4">Abschluss</h2>
                <div class="row">
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="lead">Das Gerät hat die Prüfung </p>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                    <label class="btn btn-outline-success active">
                                        <input type="radio"
                                               id="controlEquipmentPassed"
                                               name="controlEquipmentNewDueDate"
                                        >
                                        Bestanden
                                    </label>
                                    <label class="btn btn-outline-danger">
                                        <input type="radio"
                                               id="controlEquipmentNotPassed"
                                               name="controlEquipmentNewDueDate"
                                        >
                                        NICHT Bestanden
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <p class="lead">Nächste Prüfung des Gerätes</p>
                            </div>
                            <div class="col-md-6">
                                <x-datepicker id="controlNextDue" label="Fällig bis" value="{{ now()->add(
    $aci->Anforderung->an_control_interval.
    $aci->Anforderung->ControlInterval->ci_si
    )->toDateString() }}" />
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <x-textarea id="control_item_text" label="Bemerkungen zur Prüfung" />
                    </div>
                </div>
            </div>
        </div>
        <x-btnMain>Prüfung erfassen</x-btnMain>
    </div>

@endsection

@section('scripts')
    <script>
        !function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e():"function"==typeof define&&define.amd?define(e):t.SignaturePad=e()}(this,function(){"use strict";function t(t,e,i){this.x=t,this.y=e,this.time=i||(new Date).getTime()}function e(t,e,i,o){this.startPoint=t,this.control1=e,this.control2=i,this.endPoint=o}function i(t,e,i){var o,n,s,r=null,h=0;i||(i={});var a=function(){h=!1===i.leading?0:Date.now(),r=null,s=t.apply(o,n),r||(o=n=null)};return function(){var c=Date.now();h||!1!==i.leading||(h=c);var d=e-(c-h);return o=this,n=arguments,d<=0||d>e?(r&&(clearTimeout(r),r=null),h=c,s=t.apply(o,n),r||(o=n=null)):r||!1===i.trailing||(r=setTimeout(a,d)),s}}function o(t,e){var n=this,s=e||{};this.velocityFilterWeight=s.velocityFilterWeight||.7,this.minWidth=s.minWidth||.5,this.maxWidth=s.maxWidth||2.5,this.throttle="throttle"in s?s.throttle:16,this.minDistance="minDistance"in s?s.minDistance:5,this.throttle?this._strokeMoveUpdate=i(o.prototype._strokeUpdate,this.throttle):this._strokeMoveUpdate=o.prototype._strokeUpdate,this.dotSize=s.dotSize||function(){return(this.minWidth+this.maxWidth)/2},this.penColor=s.penColor||"black",this.backgroundColor=s.backgroundColor||"rgba(0,0,0,0)",this.onBegin=s.onBegin,this.onEnd=s.onEnd,this._canvas=t,this._ctx=t.getContext("2d"),this.clear(),this._handleMouseDown=function(t){1===t.which&&(n._mouseButtonDown=!0,n._strokeBegin(t))},this._handleMouseMove=function(t){n._mouseButtonDown&&n._strokeMoveUpdate(t)},this._handleMouseUp=function(t){1===t.which&&n._mouseButtonDown&&(n._mouseButtonDown=!1,n._strokeEnd(t))},this._handleTouchStart=function(t){if(1===t.targetTouches.length){var e=t.changedTouches[0];n._strokeBegin(e)}},this._handleTouchMove=function(t){t.preventDefault();var e=t.targetTouches[0];n._strokeMoveUpdate(e)},this._handleTouchEnd=function(t){t.target===n._canvas&&(t.preventDefault(),n._strokeEnd(t))},this.on()}return t.prototype.velocityFrom=function(t){return this.time!==t.time?this.distanceTo(t)/(this.time-t.time):1},t.prototype.distanceTo=function(t){return Math.sqrt(Math.pow(this.x-t.x,2)+Math.pow(this.y-t.y,2))},t.prototype.equals=function(t){return this.x===t.x&&this.y===t.y&&this.time===t.time},e.prototype.length=function(){for(var t=0,e=void 0,i=void 0,o=0;o<=10;o+=1){var n=o/10,s=this._point(n,this.startPoint.x,this.control1.x,this.control2.x,this.endPoint.x),r=this._point(n,this.startPoint.y,this.control1.y,this.control2.y,this.endPoint.y);if(o>0){var h=s-e,a=r-i;t+=Math.sqrt(h*h+a*a)}e=s,i=r}return t},e.prototype._point=function(t,e,i,o,n){return e*(1-t)*(1-t)*(1-t)+3*i*(1-t)*(1-t)*t+3*o*(1-t)*t*t+n*t*t*t},o.prototype.clear=function(){var t=this._ctx,e=this._canvas;t.fillStyle=this.backgroundColor,t.clearRect(0,0,e.width,e.height),t.fillRect(0,0,e.width,e.height),this._data=[],this._reset(),this._isEmpty=!0},o.prototype.fromDataURL=function(t){var e=this,i=arguments.length>1&&void 0!==arguments[1]?arguments[1]:{},o=new Image,n=i.ratio||window.devicePixelRatio||1,s=i.width||this._canvas.width/n,r=i.height||this._canvas.height/n;this._reset(),o.src=t,o.onload=function(){e._ctx.drawImage(o,0,0,s,r)},this._isEmpty=!1},o.prototype.toDataURL=function(t){var e;switch(t){case"image/svg+xml":return this._toSVG();default:for(var i=arguments.length,o=Array(i>1?i-1:0),n=1;n<i;n++)o[n-1]=arguments[n];return(e=this._canvas).toDataURL.apply(e,[t].concat(o))}},o.prototype.on=function(){this._handleMouseEvents(),this._handleTouchEvents()},o.prototype.off=function(){this._canvas.removeEventListener("mousedown",this._handleMouseDown),this._canvas.removeEventListener("mousemove",this._handleMouseMove),document.removeEventListener("mouseup",this._handleMouseUp),this._canvas.removeEventListener("touchstart",this._handleTouchStart),this._canvas.removeEventListener("touchmove",this._handleTouchMove),this._canvas.removeEventListener("touchend",this._handleTouchEnd)},o.prototype.isEmpty=function(){return this._isEmpty},o.prototype._strokeBegin=function(t){this._data.push([]),this._reset(),this._strokeUpdate(t),"function"==typeof this.onBegin&&this.onBegin(t)},o.prototype._strokeUpdate=function(t){var e=t.clientX,i=t.clientY,o=this._createPoint(e,i),n=this._data[this._data.length-1],s=n&&n[n.length-1],r=s&&o.distanceTo(s)<this.minDistance;if(!s||!r){var h=this._addPoint(o),a=h.curve,c=h.widths;a&&c&&this._drawCurve(a,c.start,c.end),this._data[this._data.length-1].push({x:o.x,y:o.y,time:o.time,color:this.penColor})}},o.prototype._strokeEnd=function(t){var e=this.points.length>2,i=this.points[0];if(!e&&i&&this._drawDot(i),i){var o=this._data[this._data.length-1],n=o[o.length-1];i.equals(n)||o.push({x:i.x,y:i.y,time:i.time,color:this.penColor})}"function"==typeof this.onEnd&&this.onEnd(t)},o.prototype._handleMouseEvents=function(){this._mouseButtonDown=!1,this._canvas.addEventListener("mousedown",this._handleMouseDown),this._canvas.addEventListener("mousemove",this._handleMouseMove),document.addEventListener("mouseup",this._handleMouseUp)},o.prototype._handleTouchEvents=function(){this._canvas.style.msTouchAction="none",this._canvas.style.touchAction="none",this._canvas.addEventListener("touchstart",this._handleTouchStart),this._canvas.addEventListener("touchmove",this._handleTouchMove),this._canvas.addEventListener("touchend",this._handleTouchEnd)},o.prototype._reset=function(){this.points=[],this._lastVelocity=0,this._lastWidth=(this.minWidth+this.maxWidth)/2,this._ctx.fillStyle=this.penColor},o.prototype._createPoint=function(e,i,o){var n=this._canvas.getBoundingClientRect();return new t(e-n.left,i-n.top,o||(new Date).getTime())},o.prototype._addPoint=function(t){var i=this.points,o=void 0;if(i.push(t),i.length>2){3===i.length&&i.unshift(i[0]),o=this._calculateCurveControlPoints(i[0],i[1],i[2]);var n=o.c2;o=this._calculateCurveControlPoints(i[1],i[2],i[3]);var s=o.c1,r=new e(i[1],n,s,i[2]),h=this._calculateCurveWidths(r);return i.shift(),{curve:r,widths:h}}return{}},o.prototype._calculateCurveControlPoints=function(e,i,o){var n=e.x-i.x,s=e.y-i.y,r=i.x-o.x,h=i.y-o.y,a={x:(e.x+i.x)/2,y:(e.y+i.y)/2},c={x:(i.x+o.x)/2,y:(i.y+o.y)/2},d=Math.sqrt(n*n+s*s),l=Math.sqrt(r*r+h*h),u=a.x-c.x,v=a.y-c.y,p=l/(d+l),_={x:c.x+u*p,y:c.y+v*p},y=i.x-_.x,f=i.y-_.y;return{c1:new t(a.x+y,a.y+f),c2:new t(c.x+y,c.y+f)}},o.prototype._calculateCurveWidths=function(t){var e=t.startPoint,i=t.endPoint,o={start:null,end:null},n=this.velocityFilterWeight*i.velocityFrom(e)+(1-this.velocityFilterWeight)*this._lastVelocity,s=this._strokeWidth(n);return o.start=this._lastWidth,o.end=s,this._lastVelocity=n,this._lastWidth=s,o},o.prototype._strokeWidth=function(t){return Math.max(this.maxWidth/(t+1),this.minWidth)},o.prototype._drawPoint=function(t,e,i){var o=this._ctx;o.moveTo(t,e),o.arc(t,e,i,0,2*Math.PI,!1),this._isEmpty=!1},o.prototype._drawCurve=function(t,e,i){var o=this._ctx,n=i-e,s=Math.floor(t.length());o.beginPath();for(var r=0;r<s;r+=1){var h=r/s,a=h*h,c=a*h,d=1-h,l=d*d,u=l*d,v=u*t.startPoint.x;v+=3*l*h*t.control1.x,v+=3*d*a*t.control2.x,v+=c*t.endPoint.x;var p=u*t.startPoint.y;p+=3*l*h*t.control1.y,p+=3*d*a*t.control2.y,p+=c*t.endPoint.y;var _=e+c*n;this._drawPoint(v,p,_)}o.closePath(),o.fill()},o.prototype._drawDot=function(t){var e=this._ctx,i="function"==typeof this.dotSize?this.dotSize():this.dotSize;e.beginPath(),this._drawPoint(t.x,t.y,i),e.closePath(),e.fill()},o.prototype._fromData=function(e,i,o){for(var n=0;n<e.length;n+=1){var s=e[n];if(s.length>1)for(var r=0;r<s.length;r+=1){var h=s[r],a=new t(h.x,h.y,h.time),c=h.color;if(0===r)this.penColor=c,this._reset(),this._addPoint(a);else if(r!==s.length-1){var d=this._addPoint(a),l=d.curve,u=d.widths;l&&u&&i(l,u,c)}}else{this._reset();o(s[0])}}},o.prototype._toSVG=function(){var t=this,e=this._data,i=this._canvas,o=Math.max(window.devicePixelRatio||1,1),n=i.width/o,s=i.height/o,r=document.createElementNS("http://www.w3.org/2000/svg","svg");r.setAttributeNS(null,"width",i.width),r.setAttributeNS(null,"height",i.height),this._fromData(e,function(t,e,i){var o=document.createElement("path");if(!(isNaN(t.control1.x)||isNaN(t.control1.y)||isNaN(t.control2.x)||isNaN(t.control2.y))){var n="M "+t.startPoint.x.toFixed(3)+","+t.startPoint.y.toFixed(3)+" C "+t.control1.x.toFixed(3)+","+t.control1.y.toFixed(3)+" "+t.control2.x.toFixed(3)+","+t.control2.y.toFixed(3)+" "+t.endPoint.x.toFixed(3)+","+t.endPoint.y.toFixed(3);o.setAttribute("d",n),o.setAttribute("stroke-width",(2.25*e.end).toFixed(3)),o.setAttribute("stroke",i),o.setAttribute("fill","none"),o.setAttribute("stroke-linecap","round"),r.appendChild(o)}},function(e){var i=document.createElement("circle"),o="function"==typeof t.dotSize?t.dotSize():t.dotSize;i.setAttribute("r",o),i.setAttribute("cx",e.x),i.setAttribute("cy",e.y),i.setAttribute("fill",e.color),r.appendChild(i)});var h='<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 '+n+" "+s+'" width="'+n+'" height="'+s+'">',a=r.innerHTML;if(void 0===a){var c=document.createElement("dummy"),d=r.childNodes;c.innerHTML="";for(var l=0;l<d.length;l+=1)c.appendChild(d[l].cloneNode(!0));a=c.innerHTML}var u=h+a+"</svg>";return"data:image/svg+xml;base64,"+btoa(u)},o.prototype.fromData=function(t){var e=this;this.clear(),this._fromData(t,function(t,i){return e._drawCurve(t,i.start,i.end)},function(t){return e._drawDot(t)}),this._data=t},o.prototype.toData=function(){return this._data},o});
    </script>
    <script>
        $('.btnAddControlEquipmentToList').click(function () {
            const nd = $('#set_control_equipment :selected');
            const equip_id = nd.val();
            const text = nd.text();
            const html = `
            <li class="list-group-item d-flex justify-content-between align-items-center" id="control_equipment_item_${equip_id}">
               <span>${text}</span> <input type="hidden"
                                       name="control_equipment_item_id[]"
                                       id="control_equipment_item_id_${equip_id}"
                                       value="${equip_id}"
                >
                <button type="button"
                        class="btn btn-sm m-0 btnDeleteControlEquipItem"
                        data-targetid="#control_equipment_item_${equip_id}"
                >
                    <i class="fas fa-times"></i>
                </button>
            </li>
            `;
            $('#ControlEquipmentToList').append(html);

        });
        $(document).on('click', '.btnDeleteControlEquipItem', function () {
            $(
                $(this).data('targetid')
            ).remove();
        });

        $('.btnAddSiganture').click(function(){
            const typ = $(this).data('sig');
            const signaturPrueferIDNode = $('#signaturPrueferID');
            const signaturLeitungIDNode = $('#signaturLeitungID');
            const signaturNameNode = $('#signaturName');
            signaturePad.clear();
            $('#signatureType').val(typ);
            let sigHead = (typ ==='leit') ? 'Leitung' : 'Prüfer';
            $('#sigHead').text(sigHead);
          /*  if (typ ==='pruef') signaturNameNode.val($('#messungPruefer').val());
            if (typ==='leit' && signaturLeitungIDNode.val()!==''){
                $.post( "../assets/php/ajax/getSignature.php",{ id:signaturLeitungIDNode.val() }, function( data ) {
                    console.log( data );
                    signaturePad.fromDataURL(data.img);
                    signaturNameNode.val(data.name);
                }, "json");
            }
            if (typ==='leit' && signaturPrueferIDNode.val()!==''){
                $.post( "../assets/php/ajax/getSignature.php",{ id:signaturPrueferIDNode.val() }, function( data ) {
                    console.log( data );
                    signaturePad.fromDataURL(data.img);
                    signaturNameNode.val(data.name);
                }, "json");
            }*/
        });

        $('#btnStoreSignature').click(function(){
            // var data = signaturePad.toDataURL('image/png');
            const tp = $('#signatureType').val();
           /* $.ajax({
                type: "POST",
                dataType: 'json',
                url: "../assets/php/ajax/addSignature.php",
                data: {
                    sigName:$('#signaturName').val(),
                    sigVal:signaturePad.toDataURL(),
                    sigDocNo:$('#messungPruefNr').val()
                },
                success: function (resData) {
                    if (resData.id) {
                        if (tp === 'leit') {
                            $('#signaturLeitungID').val(resData.id);
                            $('#imgSignatureLeitung').removeClass('d-none').attr('src',signaturePad.toDataURL());
                        } else {
                            $('#signaturPrueferID').val(resData.id);
                            $('#imgSignaturePruefer').removeClass('d-none').attr('src',signaturePad.toDataURL());
                        }
                        $('#signatureModal').modal('hide');
                    }
                }
            });*/
        });

        function resizeCanvas() {
            // When zoomed out to less than 100%, for some very strange reason,
            // some browsers report devicePixelRatio as less than 1
            // and only part of the canvas is cleared then.
            var ratio =  Math.max(window.devicePixelRatio || 1, 1);

            // This part causes the canvas to be cleared
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);

            // This library does not listen for canvas changes, so after the canvas is automatically
            // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
            // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
            // that the state of this library is consistent with visual state of the canvas, you
            // have to clear it manually.
            signaturePad.clear();
        }

        var canvas=document.getElementById('signatureField'),
            signaturePad = new SignaturePad(canvas, {
                velocityFilterWeight: 0.5,
                minWidth: 0.8,
                maxWidth: 1.2,
                backgroundColor: 'rgba(255, 255, 255)',
                penColor: 'rgb(8, 139, 216)'
            });

        $('#signatureModal').on('shown.bs.modal',function(){
            resizeCanvas();
        });

        // On mobile devices it might make more sense to listen to orientation change,
        // rather than window resize events.
        window.onresize = resizeCanvas;


        $('#btnClearCanvas').click(function(){signaturePad.clear();});
        $('#btnSignZuruck').click(function(){
            var data = signaturePad.toData();
            if (data) {
                data.pop(); // remove the last dot or line\n'+
                signaturePad.fromData(data);
            }
        });
    </script>

@endsection
