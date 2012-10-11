        var pathCalendar = "TDE_RCalendar";
        var minDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
        var maxDateConfigTDE = "";  //month/day/year like this "10/5/2008" or "now" for current date
		YAHOO.namespace("RCalendar");
		var calendarArray = new Array();
		
		function configLanguage(lang){
			var ms,	ml, wc,ws, wm, wl;
				switch(lang){
					case "DE":
						ms = ["Jan", "Feb", "M&auml;r", "Apr", "Mai", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dez"];
						ml = ["Januar", "Februar", "M&auml;rz", "April", "Mai", "Juni", "Juli", "August", "September", "Oktober", "November", "Dezember"];
						wc = ["S", "M", "D", "M", "D", "F", "S"];
						ws = ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"];
						wm = ["Son", "Mon", "Die", "Mit", "Don", "Fre", "Sam"];
						wl = ["Sonntag", "Montag", "Dienstag", "Mittwoch", "Donnerstag", "Freitag", "Samstag"];
					break;
					case "SP":
						ms = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];
						ml = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
						wc = ["D", "L", "M", "M", "J", "V", "S"];
						ws = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"];
						wm = ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"];
						wl = ["Domingo", "Lunes", "Martes", "Mi&eacute;rcoles", "Jueves", "Viernes", "S&acute;bado"];
					break;
					case "FR":
						ms = ["Jan", "F&eacute;v", "Mar", "Avr", "Mai", "Jui", "Jui", "Ao&ucirc;", "Sep", "Oct", "Nov", "D&eacute;c"];
						ml = ["Janvier", "F&eacute;vrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Ao&ucirc;t", "Septembre", "Octobre", "Novembre", "D&eacute;cembre"];
						wc = ["D", "L", "M", "M", "J", "V", "S"];
						ws = ["Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa"];
						wm = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];
						wl = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
					break;
					case "IT":
						ms = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Aug", "Set", "Ott", "Nov", "Dic"];
						ml = ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"];
						wc = ["D", "L", "M", "M", "G", "V", "S"];
						ws = ["Do", "Lu", "Ma", "Me", "Gi", "Ve", "Sa"];
						wm = ["Dom", "Lun", "Mar", "Mer", "Gio", "Ven", "Sab"];
						wl = ["Domenica", "Luned&igrave;", "Marted&igrave;", "Mercoled&igrave;", "Gioved&igrave;", "Venerd&igrave;", "Sabato"];
					break;
					case "PT":
						ms = ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"];
						ml = ["Janeiro", "Fevereiro", "Mar&ccedil;o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
						wc = ["D", "S", "T", "Q", "Q", "S", "S"];
						ws = ["Do", "Se", "Te", "Qu", "Qu", "Se", "Sa"];
						wm = ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "S&aacute;b"];
						wl = ["Domingo", "Seg", "Ter", "Quarta", "Qui", "Sex", "S&aacute;bado"];
					break;
					case "JP":
						ms = ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"];
						ml = ["1\u6708", "2\u6708", "3\u6708", "4\u6708", "5\u6708", "6\u6708", "7\u6708", "8\u6708", "9\u6708", "10\u6708", "11\u6708", "12\u6708"];
						wc = ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"];
						ws = ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"];
						wm = ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"];
						wl = ["\u65E5", "\u6708", "\u706B", "\u6C34", "\u6728", "\u91D1", "\u571F"];
					break;					
					case "DU":
						ms = ["Jan", "Feb", "Maa", "Apr", "Mei", "Jun", "Jul", "Aug", "Sep", "Okt", "Nov", "Dec"];
						ml = ["Januari", "Februari", "Maart", "April", "Mei", "Juni", "Juli", "Augustus", "September", "Oktober", "November", "December"];
						wc = ["Z", "M", "D", "W", "D", "V", "Z"];
						ws = ["Zo", "Ma", "Di", "Wo", "Do", "Vr", "Za"];
						wm = ["Zon", "Maa", "Din", "Woe", "Don", "Vri", "Zat"];
						wl = ["Zondag", "Maandag", "Dinsdag", "Woensdag", "Donderdag", "Vrijdag", "Zaterdag"];
					break;	
					default:
						return;
					break;
				}
				YAHOO.widget.myCalendar_Core.prototype.customConfig = function() {
				this.Config.Locale.MONTHS_SHORT = ms;
				this.Config.Locale.MONTHS_LONG = ml;
				this.Config.Locale.WEEKDAYS_1CHAR = wc;
				this.Config.Locale.WEEKDAYS_SHORT = ws;
				this.Config.Locale.WEEKDAYS_MEDIUM = wm;
				this.Config.Locale.WEEKDAYS_LONG = wm;
				}
		}	
		
		// Resets the year to its previous valid value when something invalid is entered
		function FixYearInput(YearField) {
			 var todayDate = new Date();	
		   var YearRE = new RegExp('\\d{' + 4 + '}');
		   if (!YearRE.test(YearField.value)) YearField.value = todayDate.getFullYear();
		}
		
		function showCalendar(calendarId) {
			var linkToCalendar = document.getElementById("dateR"+calendarId);
			var calendarContainer = document.getElementById("RCalendar"+calendarId);
			var pos = YAHOO.util.Dom.getXY("dateR"+calendarId);
			calendarContainer.style.display='block';
			YAHOO.util.Dom.setXY(calendarContainer, [pos[0],pos[1]+linkToCalendar.offsetHeight+1]);
		}

		
		function htmlContruct(calendarId)
		{
		    var divCal = document.getElementById("containerRCalendar"+calendarId);
		    divCal.innerHTML = '<div id="RCalendar'+calendarId+'"><div  style="position:relative;"><div id="RCalendar'+calendarId+'Layer" style="display:none;position:absolute;border:1px solid #7B9EBD;background-color:#F7F9FB;left:6px;top:25px;padding:15px"><div id="RCalendar'+calendarId+'SelectAdd" name="RCalendar'+calendarId+'SelectAdd" style="display:none;"></div><div id="RCalendar'+calendarId+'SelectEdit" name="RCalendar'+calendarId+'SelectEdit" style="display:none;"><select id="RCalendar'+calendarId+'Select" name="RCalendar'+calendarId+'Select" onchange="renderselect(this,\'RCalendar'+calendarId+'\');"><option value="1">sdf</select></div><div>Title<br /><input type="text" name="RCalendar'+calendarId+'title" id="RCalendar'+calendarId+'title" value="Title" style="width:270px" /></div>Comments<br /><textarea style="width:270px" name="RCalendar'+calendarId+'comment" id="RCalendar'+calendarId+'comment">Comment...</textarea><br /><br /><div style="text-align:left"><div id="RCalendar'+calendarId+'ButtonsAdd" name="RCalendar'+calendarId+'ButtonsAdd" style="display:none;float:left"><input type="button" name="save" value="Save" onclick="javascript:saveCalendar(\'RCalendar'+calendarId+'\')"/>&nbsp;<input type="button" name="cancel" value="Cancel" onclick="javascript:closeDivAdd(\'RCalendar'+calendarId+'\')"/></div><div id="RCalendar'+calendarId+'ButtonsEdit" name="RCalendar'+calendarId+'ButtonsEdit" style="display:none;float:left"><input type="button" name="edit" value="Save" onclick="javascript:editCalendar(\'RCalendar'+calendarId+'\')"/>&nbsp;<input type="button" name="del" value="Delete" onclick="javascript:deleteRangeR(\'RCalendar'+calendarId+'\')"/>&nbsp;<input type="button" name="canceledit" value="Cancel" onclick="javascript:closeDivAdd(\'RCalendar'+calendarId+'\')"/></div></div></div></div><input type="hidden" name="RCalendar'+calendarId+'range" id="RCalendar'+calendarId+'range" value=""/><input type="hidden" value="misdatos" name="xmldates" id="xmldates"></div><div id="RCalendar'+calendarId+'Events" class="eventlist" ></div>';
		    
	    }
	    function updateEventList(calendarId,type)
		{
		    var eventList = document.getElementById("RCalendar"+calendarId+"Events");
		    if (calendarArray["RCalendar"+calendarId].admin) 
		    {
		        if (type==-1)
		        {
		            eventList.innerHTML = '<a href="javascript:updateEventList(\''+calendarId+'\',1);"><img src="'+YAHOO.widget.myCalendar_Core.IMG_ROOT+'events.gif" border="0"></a>';
		            
		        }    
		        else
		        {	        
		            calID = "RCalendar"+calendarId;
		            var htmltext = '<div><div style="float:left"><a href="javascript:updateEventList(\''+calendarId+'\',1);"><div class="event-button">Month</div></a></div><div style="float:left"><a href="javascript:updateEventList(\''+calendarId+'\',0);"><div class="event-button">All</div></a></div><div style="float:right"><a href="javascript:updateEventList(\''+calendarId+'\',-1);"><img src="'+YAHOO.widget.myCalendar_Core.IMG_ROOT+'close.gif" border="0"></a></div><div style="clear:both"></div></div>';
			        for (i=0;i<calendarArray[calID].reservedDates.length;i++)
			        {
			            tmp = calendarArray[calID].reservedDates[i].range.split("-");
        	            t1 = tmp[0].split("/");
        	            t2 = tmp[1].split("/");
        	            if (calendarArray[calID].invertDate)
        	                tt = t1[1] + "/" + t1[0] + "/" + t1[2] +"-" + t2[1] + "/" + t2[0] + "/" + t2[2];
        	            else
        	                tt = t1[0] + "/" + t1[1] + "/" + t1[2] +"-" + t2[0] + "/" + t2[1] + "/" + t2[2];
			            if (type==1)
			            {
			                r = getEnds(calendarArray[calID].reservedDates[i].range,calID);
			                current = calendarArray[calID].pageDate.getMonth();
			                if ((current == r[0].getMonth()) || (current == r[1].getMonth()))
			                   htmltext += "<font class=\"smallf\">"+tt+": </font><b>"+calendarArray[calID].reservedDates[i].title+"</b><br/> "+calendarArray[calID].reservedDates[i].comment+"<a href=\"javascript:deleteRangeList('"+calendarId+"','"+calendarArray[calID].reservedDates[i].range+"',"+type+")\"><img src=\""+YAHOO.widget.myCalendar_Core.IMG_ROOT+"delete.gif\" align=\"absmiddle\" alt=\"Delete\" border=\"0\"></a><br /><br />";
			            }
			            else
			                htmltext +=    "<font class=\"smallf\">"+tt+": </font><b>"+calendarArray[calID].reservedDates[i].title+"</b><br/> "+calendarArray[calID].reservedDates[i].comment+"<a href=\"javascript:deleteRangeList('"+calendarId+"','"+calendarArray[calID].reservedDates[i].range+"',"+type+")\"><img src=\""+YAHOO.widget.myCalendar_Core.IMG_ROOT+"delete.gif\" align=\"absmiddle\" alt=\"Delete\" border=\"0\"></a><br /><br />";
			        }
			        eventList.innerHTML = '<div class="yui-calcontainer">'+htmltext+'</div>';    
                }  
            }     
            
		    
	    }
		
		function initCalendar(calendarId,language, admin,ends,msgStart,msgEnd,msgCancel,msgSuccessfully) {
		
		    
			htmlContruct(calendarId);
			calID = "RCalendar"+calendarId;
			
		    var todayDate = new Date();
			
			var calendarContainer = document.getElementById(calID);
			var calendarVisibility = calendarContainer.style.display;
			
			configLanguage(language);
			
			
			if (admin)
			    YAHOO.widget.myCalendar_Core.IMG_ROOT="../";
			else
			    YAHOO.widget.myCalendar_Core.IMG_ROOT= pathCalendar+"/";
			
			
			calendarArray[calID] = new YAHOO.widget.Calendar("calendarArray[RCalendar"+calendarId+"]", calID);
			if (minDateConfigTDE == "now")
			    calendarArray[calID].minDate = new Date();
			else
			{
			    tmp = minDateConfigTDE.split("/")
			    calendarArray[calID].minDate = new Date(tmp[2],(tmp[0]-1),tmp[1]);   
			}
			if (maxDateConfigTDE == "now")
			    calendarArray[calID].maxDate = new Date();
			else
			{
			    tmp = maxDateConfigTDE.split("/")
			    calendarArray[calID].maxDate = new Date(tmp[2],(tmp[0]-1),tmp[1]);   
			}    
			calendarArray[calID].admin = admin;
			calendarArray[calID].identifier = calID;
			calendarArray[calID].ends = ends;
			calendarArray[calID].msgStart = msgStart;
			calendarArray[calID].msgEnd = msgEnd;
			calendarArray[calID].msgCancel = msgCancel;
			calendarArray[calID].msgSuccessfully = msgSuccessfully;
			
			
			calendarArray[calID].renderBodyCellReserved = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "reserved");
		    }
		    calendarArray[calID].renderBodyCellReserved_left = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "reserved_left");
		    }
		    calendarArray[calID].renderBodyCellReserved_right = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "reserved_right");
		    }
		    calendarArray[calID].renderBodyCellReserved_middle = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "reserved_middle");
		    }
		    
		    calendarArray[calID].renderBodyCellPending = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "pending");
		    }
		    calendarArray[calID].renderBodyCellPending_left = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "pending_left");
		    }
		    calendarArray[calID].renderBodyCellPending_right = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "pending_right");
		    }
		    calendarArray[calID].renderBodyCellPending_middle_left = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "pending_middle_left");
		    }
		    calendarArray[calID].renderBodyCellPending_middle_right = function(workingDate, cell) {
					YAHOO.util.Dom.addClass(cell, "pending_middle_right");
		    }
		    
			
			calendarArray[calID].startday = "";
			calendarArray[calID].reservedDates = new Array();
			calendarArray[calID].endsDates = new Array();
			var r = initDates(calID);
			r = r.replace(/\r/g, "");
		    var tmp = new Array();
		    var tmp2 = new Array();
		    tmp = r.split("\n*-*\n");
		    
		    for (i=0;i<(tmp.length-1);i++)
		    {
		        tmp2 = tmp[i].split("\n");
		        myrange = {range:tmp2[0],title:tmp2[1],comment:tmp2[2]};
		        calendarArray[calID].reservedDates[i] = myrange;		        
		        addRenderCalendar(calID,tmp2[0]);
		    }	    	
			
			calendarArray[calID].render();
			
			
			calendarArray[calID].onSelect = function(){
				var calendarDate = this.getSelectedDates()[0];
				
				calendarContainer.style.display=calendarVisibility;
			};
			
			
            updateEventList(calendarId,-1);
			addClick("",calendarArray[calID]); ///marcar visualmente como add
			
		}
		
		function getSelectedDates(calendarId){
			return calendarArray[calendarId].getSelectedDates();
		}
		
		function resetSelectedDates(calendarId){
			calendarArray[calendarId].reset();
		}
		function getRequest()
        {
              http_request = false;
              if (window.XMLHttpRequest) { // Mozilla, Safari,...
                 http_request = new XMLHttpRequest();
                 if (http_request.overrideMimeType) {
                 	// set type accordingly to anticipated content type
                    //http_request.overrideMimeType('text/xml');
                    http_request.overrideMimeType('text/html');
                 }
              } else if (window.ActiveXObject) { // IE
                 try {
                    http_request = new ActiveXObject("Msxml2.XMLHTTP");
                 } catch (e) {
                    try {
                       http_request = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {}
                 }
              }
              if (!http_request) {
                 alert('Cannot create XMLHTTP instance');
                 return false;
              }
              return http_request;
        }
        function initDates(id)
        {
            http_request = getRequest();   
            http_request.open("GET", pathCalendar+"/?dex_reservations_calendar_load2=1&id="+id+"&nocache="+Math.random(), false);
            http_request.send(null);
            var text = http_request.responseText;
            text = text.replace(/%26/g, "&");  
            return text;
        }
        
        
        
        function dateChanged(y,m,d,calID)
        { 
            if (calendarArray[calID].admin)
            {
                if (calendarArray[calID].actionstate=='add' && (inrange(new Date(y, (m-1), d),calID)==-1))
                {
        	        if (calendarArray[calID].startday=="" )
        	        {
        	            calendarArray[calID].startday = m + "/" + d + "/" + y;
        	            showLabel(calendarArray[calID]);
        	        }    
        	        else if ((calendarArray[calID].ends == true && calendarArray[calID].startday!=(m + "/" + d + "/" + y)) || calendarArray[calID].ends == false) 
        	        {
        	            range = calendarArray[calID].startday+"-"+m + "/" + d + "/" + y;        	                
        	            var d1 = getEnds(range,calID);
                        if (d1[1] < d1[0])
                        {
                            var swap = d1[1];
                            d1[1] = d1[0]
                            d1[0] = swap;
                        }
                        range = getRange(d1[0],d1[1]); 
                        if (!outrange(range,calID))
                        {           	  
        	                layer = document.getElementById(calID+"Layer");
        	                layer.style.display = "";
        	                divAdd = document.getElementById(calID+"SelectAdd");
        	                ss = range;        	                
        	                tmp = ss.split("-");
        	                t1 = tmp[0].split("/");
        	                t2 = tmp[1].split("/");
        	                if (calendarArray[calID].invertDate)
        	                    divAdd.innerHTML = "<strong>From: </strong>" + t1[1] + "/" + t1[0] + "/" + t1[2] +" <strong>To:</strong> " + t2[1] + "/" + t2[0] + "/" + t2[2];
        	                else
        	                    divAdd.innerHTML = "<strong>From: </strong>" + t1[0] + "/" + t1[1] + "/" + t1[2] +" <strong>To:</strong> " + t2[0] + "/" + t2[1] + "/" + t2[2];
        	                divAdd.style.display = "";
        	                divAdd = document.getElementById(calID+"ButtonsAdd");
        	                divAdd.style.display = "";
        	                inputrange = document.getElementById(calID+"range");
        	                inputrange.value = range;
        	                renderCalendar(calID);
        	            }
        	        }
        	    }    
        	    else if (calendarArray[calID].actionstate=='edit')
                {
                    calendarArray[calID].rangesSelected = new Array();
                    calendarArray[calID].rangesSelected = inrangeArray(new Date(y, (m-1), d),calID);
        	        if (calendarArray[calID].rangesSelected.length > 0) //al menos esta dentro de un rango
        	        {
        	            
        	            oSelect = document.getElementById(calID+"Select");        	        
        	            clearOptions(oSelect);
        	            var oOption;
        	            for (i=0;i<calendarArray[calID].rangesSelected.length;i++)
        	            {
        	                oOption = document.createElement("OPTION");
        	                tmp = calendarArray[calID].rangesSelected[i].range.split("-");
        	                t1 = tmp[0].split("/");
        	                t2 = tmp[1].split("/");
        	                if (calendarArray[calID].invertDate)
        	                    oOption.text = t1[1] + "/" + t1[0] + "/" + t1[2] +"-" + t2[1] + "/" + t2[0] + "/" + t2[2];
        	                else
        	                    oOption.text = t1[0] + "/" + t1[1] + "/" + t1[2] +"-" + t2[0] + "/" + t2[1] + "/" + t2[2];
                            oOption.value= calendarArray[calID].rangesSelected[i].range;
                            
                            if(navigator.userAgent.indexOf('MSIE') != -1) 
                                oSelect.add(oOption);
			    	        else 
			    	            oSelect.add(oOption, null);
        	            }
        	            layer = document.getElementById(calID+"Layer");
        	            layer.style.display = "";
        	            divEdit = document.getElementById(calID+"SelectEdit");
        	            divEdit.style.display = "";
        	            divEdit = document.getElementById(calID+"ButtonsEdit");
        	            divEdit.style.display = "";
        	            
        	            updateinput(calID,calendarArray[calID].rangesSelected[0]);
        	        }
                }
            }
            else
            {
                if (calendarArray[calID].actionstate=='add' && (inrange(new Date(y, (m-1), d),calID)==-1))
                {
        	        if (calendarArray[calID].startday=="" )
        	        {
        	            calendarArray[calID].startday = m + "/" + d + "/" + y;
        	            showLabel(calendarArray[calID],"add");
        	            
        	        }    
        	        else 
        	        {
        	            if ((calendarArray[calID].ends == true && calendarArray[calID].startday!=(m + "/" + d + "/" + y)) || calendarArray[calID].ends == false)
        	            {
        	                range = calendarArray[calID].startday+"-"+m + "/" + d + "/" + y;        	                
        	                var d1 = getEnds(range,calID);
                            if (d1[1] < d1[0])
                            {
                                var swap = d1[1];
                                d1[1] = d1[0]
                                d1[0] = swap;
                            }
                            range = getRange(d1[0],d1[1]);   
                            if (!outrange(range,calID))
                            {     	                
        	                    renderCalendar(calID,range);
        	                    showLabel(calendarArray[calID],"edit");
        	                    calendarArray[calID].actionstate='edit';
        	                    setInputs(calID,d1[0],d1[1]);
        	                    
        	                }
        	            }
        	            
        	        }
        	    }  
            }
        	
        	 
        }
        function setInputs(calID,d1,d2)
        {
            var calendarId =calID.replace(/RCalendar/g, "");
        	var selMonth_start = document.getElementById("selMonth_start"+calendarId); 
        	selMonth_start.value = (d1.getMonth()+1);
			var selDay_start = document.getElementById("selDay_start"+calendarId);
			selDay_start.value = d1.getDate();
			var selYear_start = document.getElementById("selYear_start"+calendarId);
			selYear_start.value = d1.getFullYear();
			
        	var selMonth_end = document.getElementById("selMonth_end"+calendarId); 
        	selMonth_end.value = d2.getMonth()+1;
			var selDay_end = document.getElementById("selDay_end"+calendarId);
			selDay_end.value = d2.getDate();
			var selYear_end = document.getElementById("selYear_end"+calendarId);
			selYear_end.value = d2.getFullYear();;
        }
        function clearInputs(calID)
        {
            var calendarId =calID.replace(/RCalendar/g, "");
        	var selMonth_start = document.getElementById("selMonth_start"+calendarId); 
        	selMonth_start.value = "";
			var selDay_start = document.getElementById("selDay_start"+calendarId);
			selDay_start.value = "";
			var selYear_start = document.getElementById("selYear_start"+calendarId);
			selYear_start.value = "";
			
        	var selMonth_end = document.getElementById("selMonth_end"+calendarId); 
        	selMonth_end.value = "";
			var selDay_end = document.getElementById("selDay_end"+calendarId);
			selDay_end.value = "";
			var selYear_end = document.getElementById("selYear_end"+calendarId);
			selYear_end.value = "";
        }
        function outrange(range,calID)
        {
            var d1 = getEnds(range,calID); 
            for (i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                dn = getEnds(calendarArray[calID].reservedDates[i].range,calID);
                a = dn[0];
                b = dn[1];                
                if ((a >= d1[0]) && (b <= d1[1]))  // si esta dentro del rango
                    return true;    
            }
            return false;
        }
        function inrange(d,calID,del)
        {
            
            var range = -1;
            var middle = -1;
            for (var i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                var dn = getEnds(calendarArray[calID].reservedDates[i].range,calID);
                var a = dn[0];
                var b = dn[1];
                
                if (calendarArray[calID].ends == true && (!del==true)) 
                {
                    
                    if (a < d && b > d)  // si esta dentro del rango
                    {                        
                        range =  i;
                    }    
                    else if (a.toString()==d.toString() || b.toString()==d.toString())
                    {
                       if (middle!=-1)
                           range = middle;
                       else
                           middle = i; 
                              
                    }      
                }
                else
                {
                    if (a <= d && b >= d)  // si esta dentro del rango
                        range =  i; 
                }                  
            }
            return range;
        }
        function inrangeArray(d,calID)
        {
            range = new Array();
            for (i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                dn = getEnds(calendarArray[calID].reservedDates[i].range,calID);
                a = dn[0];
                b = dn[1];
                doadd = true;
                if (a <= d && b >= d)  // si esta dentro del rango
                {                    
                    range[range.length] =  calendarArray[calID].reservedDates[i];
                }                    
            }
            return range;
        }
        function getRange(d1,d2)
        {
            return (d1.getMonth()+1)+'/'+d1.getDate()+'/'+d1.getFullYear()+'-'+(d2.getMonth()+1)+'/'+d2.getDate()+'/'+d2.getFullYear();
        }
        function getEnds(range,calID) // devuelve un arreglo con los dias estremos del rango
        {
            var d1,d2,s,pos;
            s = range;
            pos = s.indexOf("-");
            d1 = calendarArray[calID]._parseDate(s.substr(0,pos));
            d2 = calendarArray[calID]._parseDate(s.substr(pos+1));
            return new Array(new Date(d1[0],d1[1]-1,d1[2]),new Date(d2[0],d2[1]-1,d2[2]));
        }
        
        function renderCalendar(calID,range)
        {       
            calendarArray[calID].clearAllItems();
            calendarArray[calID].endsDates = new Array();
            for (i=0;i<calendarArray[calID].reservedDates.length;i++) 
                addRenderCalendar(calID,calendarArray[calID].reservedDates[i].range); 
            if (range)    
                addRenderCalendarPending(calID,range);    
           
        	calendarArray[calID].render();
        	updateEventList(calID.replace(/RCalendar/g, ""),-1);
        	
        }
        function addCalendar(range,title,comment,calID)
        {
            var d,dn,swap;
            var tmp = new Array();
            var tmptitle = new Array();
            var tmpcomment = new Array();
            var top = 0;
            var located = false;
            d = getEnds(range,calID);            
            if (d[1] < d[0])
            {
                swap = d[1];
                d[1] = d[0]
                d[0] = swap;
            }
            for (i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                
                
                myrange = {range:calendarArray[calID].reservedDates[i].range,title:calendarArray[calID].reservedDates[i].title,comment:calendarArray[calID].reservedDates[i].comment};
                tmp[top++] = myrange;
                
            }
            myrange = {range:getRange(d[0],d[1]),title:title,comment:comment};
            tmp[top++] = myrange;
            
            calendarArray[calID].reservedDates = tmp; 
            
            makePOSTRequest(calID); 
        }
        function makePOSTRequest(calID) {  
         
           var strdates = "";
           for (i=0;i<calendarArray[calID].reservedDates.length;i++)
               strdates += calendarArray[calID].reservedDates[i].range+"\n"+calendarArray[calID].reservedDates[i].title+"\n"+calendarArray[calID].reservedDates[i].comment+"\n*-*\n";
           strdates = strdates.replace(/&/g, "%26");      
           parameters = "xmldates=" + encodeURI(strdates)   ;
           http_request = getRequest();      
           http_request.onreadystatechange = alertContents;
           http_request.open('POST',pathCalendar+"/?dex_reservations_calendar_update2=1&id='+calID, true);
           http_request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           
           parameters += "&id=" + encodeURI( calID );
           
           http_request.setRequestHeader("Content-length", parameters.length);
           http_request.setRequestHeader("Connection", "close");
           http_request.send(parameters);
        }
        function alertContents() {
           if (http_request.readyState == 4) {
              if (http_request.status == 200) {
                 var str = http_request.responseText;
                 if (str.indexOf("Permission denied") > 0 || str.indexOf("failed to open stream") > 0)
                     alert('PROBLEM: The server has returned a "PERMISSION DENIED" error. \n\nSOLUTION: Please set write permissions to the folder "TDE_RCalendar\\admin\\database" and to all the files inside that folder.\n\nTIP: FTP programs ("clients") allow you to set permissions for files and directories on your remote host. This function is often called chmod or set permissions in the program menu. You must set the permissions to 777 (rwxrwxrwx). If you are not sure about setting write permissions, please contact your hosting support and ask them to set the permissions.');      
              } else {
                 var str = http_request.responseText;
                 if (str.indexOf("Permission denied") > 0 || str.indexOf("failed to open stream") > 0)
                     alert('PROBLEM: The server has returned a "PERMISSION DENIED" error. \n\nSOLUTION: Please set write permissions to the folder "TDE_RCalendar\\admin\\database" and to all the files inside that folder.\n\nTIP: FTP programs ("clients") allow you to set permissions for files and directories on your remote host. This function is often called chmod or set permissions in the program menu. You must set the permissions to 777 (rwxrwxrwx). If you are not sure about setting write permissions, please contact your hosting support and ask them to set the permissions.');
                 else    
                     alert('There was a problem with the request.');
              }
           }
        }
        function closeDivAdd(calID)
        {
            layer = document.getElementById(calID+"Layer");
        	layer.style.display = "none";
        	divEdit = document.getElementById(calID+"SelectEdit");
        	divEdit.style.display = "none";
        	divEdit = document.getElementById(calID+"ButtonsEdit");
        	divEdit.style.display = "none";
        	divAdd = document.getElementById(calID+"SelectAdd");
        	divAdd.style.display = "none";
        	divAdd = document.getElementById(calID+"ButtonsAdd");
        	divAdd.style.display = "none";
        	calendarArray[calID].startday = ""; 
        	showLabel(calendarArray[calID]);
        }
        function cancelSelection(calID)
        {
            calendarArray[calID].startday = "";
        	renderCalendar(calID);
        	calendarArray[calID].actionstate='add';
        	showLabel(calendarArray[calID]);
        	clearInputs(calID);
            
        }
        
        function saveCalendar(calID)
        {
            
            inputrange = document.getElementById(calID+"range");
            inputtitle = document.getElementById(calID+"title");
            inputcomment = document.getElementById(calID+"comment");
            
            addCalendar(inputrange.value,inputtitle.value,inputcomment.value,calID);
            
            renderCalendar(calID);
        	closeDivAdd(calID);
        }
        function editCalendar(calID)
        {
            
            selectDomElement = document.getElementById(calID+"Select");
            inputtitle = document.getElementById(calID+"title");
            inputcomment = document.getElementById(calID+"comment");
            located = false;
            for (i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                if ((calendarArray[calID].reservedDates[i].range == calendarArray[calID].rangesSelected[0].range) && !located)
                {
                    located = true;
                    
                    k = i + selectDomElement.selectedIndex;
                    
                    calendarArray[calID].reservedDates[k].title = inputtitle.value;
                    
                    calendarArray[calID].rangesSelected[selectDomElement.selectedIndex].title = inputtitle.value;
                    calendarArray[calID].reservedDates[k].comment = inputcomment.value;
                    calendarArray[calID].rangesSelected[selectDomElement.selectedIndex].comment = inputcomment.value;
                }              
            }
            
            makePOSTRequest(calID); 
        	closeDivAdd(calID);
        	updateEventList(calID.replace(/RCalendar/g, ""),-1);
        }
        function deleteRangeList(calendarId,value,type)
        {
            deleteRange('RCalendar'+calendarId,value);
            updateEventList(calendarId,type);
        }
        function deleteRangeR(calID)
        {
            var d,dn,swap;
            var tmp = new Array();
            var tmptitle = new Array();
            var tmpcomment = new Array();
            
            inputrange = document.getElementById(calID+"range");
            deleteRange(calID,inputrange.value);
           
                       
            closeDivAdd(calID);
        }
        function deleteRange(calID,value)
        {
            var d,dn,swap;
            var tmp = new Array();
            var tmptitle = new Array();
            var tmpcomment = new Array();
            dn = getEnds(value,calID);
            s = value;
            pos = s.indexOf("-");
            d1 = calendarArray[calID]._parseDate(s.substr(0,pos));
            k = inrange(new Date(d1[0],d1[1]-1,d1[2]),calID,true);
            for (i=0;i<calendarArray[calID].reservedDates.length;i++)
            {
                if (i<k)
                {   
                    tmp[i] = calendarArray[calID].reservedDates[i];
                }
                else if (i>k)
                {
                    tmp[i-1] = calendarArray[calID].reservedDates[i];
                }
                       
            }
            calendarArray[calID].reservedDates = tmp;
            makePOSTRequest(calID);  
            renderCalendar(calID);
        }
        
        
        
        
        /////////////////////////////////////////////////////////////////////////////////////
function addMouseOver(e,tag)
{
    YAHOO.util.Dom.addClass(tag, "calcellADDH");
}
function addMouseOut(e,tag)
{
    YAHOO.util.Dom.removeClass(tag, "calcellADDH");
}
function addClick(e,cal)
{
    clearClick(cal);
    YAHOO.util.Dom.addClass(cal.table, "yui-calcontainerADD");
    YAHOO.util.Dom.addClass(cal.tagadd, "calcellADDSeleted");
    cal.actionstate = "add";
    
    showLabel(cal);
}

function editMouseOver(e,tag)
{
    YAHOO.util.Dom.addClass(tag, "calcellEDITH");
}
function editMouseOut(e,tag)
{
    YAHOO.util.Dom.removeClass(tag, "calcellEDITH");
}
function editClick(e,cal)
{
    clearClick(cal);
    YAHOO.util.Dom.addClass(cal.table, "yui-calcontainerEDIT");
    YAHOO.util.Dom.addClass(cal.tagedit, "calcellEDITSeleted");
    cal.actionstate = "edit";
    showLabel(cal);
}

function clearClick(cal)
{
    YAHOO.util.Dom.removeClass(cal.table, "yui-calcontainerADD");
    YAHOO.util.Dom.removeClass(cal.tagadd, "calcellADDSeleted");
    YAHOO.util.Dom.removeClass(cal.table, "yui-calcontainerEDIT");
    YAHOO.util.Dom.removeClass(cal.tagedit, "calcellEDITSeleted");
    YAHOO.util.Dom.removeClass(cal.table, "yui-calcontainerDEL");
    YAHOO.util.Dom.removeClass(cal.tagdel, "calcellDELSeleted");
}
function showLabel(cal,label)
{
    if (cal.admin)
    {
        switch (cal.actionstate)
        {
            case "add":
                if (cal.startday=="")
                    cal.label.innerHTML = "Select Start Date";
                else
                    cal.label.innerHTML = '<div class="sennaled">Select End Date or <a href="javascript:closeDivAdd(\''+cal.identifier+'\')" class="sennaled">cancel</a></div>';
            break;
            case "edit":
                cal.label.innerHTML = "Edit Event";
            break;
        }
    }
    else
    {
        switch (label)
        {
            case "add":
                cal.label.innerHTML = '<div style="background-color:#A7B8DE;color:#ffffff;">'+cal.msgEnd+'</div><a href="javascript:closeDivAdd(\''+cal.identifier+'\')" ><div style="background-color:#F57A59;color:#ffffff;border-top:1px solid white ">'+cal.msgCancel+'</div></a>';
            break;
            case "edit":
                cal.label.innerHTML = '<div style="background-color:#A7B8DE;color:#ffffff;">'+cal.msgSuccessfully+' </div><a href="javascript:cancelSelection(\''+cal.identifier+'\')" ><div style="background-color:#F57A59;color:#ffffff;border-top:1px solid white ">'+cal.msgCancel+'</div></a>';
            break;
            default:
                cal.label.innerHTML = cal.msgStart;
        }
           
            
    }    
}
function clearOptions(selectDomElement)
{
	while(selectDomElement.length > 0)
		selectDomElement.remove(0);
}
function updateinput(calID,selected)
{
    
    inputrange = document.getElementById(calID+"range");
    
    inputrange.value = selected.range;
    inputtitle = document.getElementById(calID+"title");
    inputtitle.value = selected.title;
    inputcomment = document.getElementById(calID+"comment");
    inputcomment.value = selected.comment;
}			
function renderselect(selectDomElement,calID)
{
    updateinput(calID,calendarArray[calID].rangesSelected[selectDomElement.selectedIndex]);
}
function addRenderCalendar(calID,range)
{
    
    if (calendarArray[calID].ends == true)
    {
        
        dn = getEnds(range,calID);
        a = dn[0];
        b = dn[1];
        
        var a_found = false;
        var b_found = false;
        
        for (var i=0;i<(calendarArray[calID].endsDates.length);i++)
        {
            if (a.toString()==calendarArray[calID].endsDates[i].toString())
                a_found = true;
            if (b.toString()==calendarArray[calID].endsDates[i].toString())
                b_found = true;   
            
        }
        
        if (a_found)
            calendarArray[calID].addRenderer((a.getMonth()+1)+'/'+a.getDate()+'/'+a.getFullYear(), calendarArray[calID].renderBodyCellReserved_middle);
        else
        {  
            
            calendarArray[calID].endsDates[(calendarArray[calID].endsDates.length)] = a;
            calendarArray[calID].addRenderer((a.getMonth()+1)+'/'+a.getDate()+'/'+a.getFullYear(), calendarArray[calID].renderBodyCellReserved_left);
        }
        if (b_found)
            calendarArray[calID].addRenderer((b.getMonth()+1)+'/'+b.getDate()+'/'+b.getFullYear(), calendarArray[calID].renderBodyCellReserved_middle);
        else
        {  
            
            calendarArray[calID].endsDates[(calendarArray[calID].endsDates.length)] = b;
            calendarArray[calID].addRenderer((b.getMonth()+1)+'/'+b.getDate()+'/'+b.getFullYear(), calendarArray[calID].renderBodyCellReserved_right);
        }          
        a = YAHOO.widget.DateMath.add(a, YAHOO.widget.DateMath.DAY, 1);
        b = YAHOO.widget.DateMath.subtract(b, YAHOO.widget.DateMath.DAY, 1);
        if (a <= b)//son mas de 2
        {            
            if (calendarArray[calID].admin)
                calendarArray[calID].addRenderer(getRange(a,b), calendarArray[calID].renderBodyCellReserved);
            else
                calendarArray[calID].addRenderer(getRange(a,b), calendarArray[calID].renderBodyCellRestricted);
        }    
            
    }
    else 
    {
        if (calendarArray[calID].admin)
        calendarArray[calID].addRenderer(range, calendarArray[calID].renderBodyCellReserved);   
        else
        calendarArray[calID].addRenderer(range, calendarArray[calID].renderBodyCellRestricted);   
    }    
}
function addRenderCalendarPending(calID,range)
{   
    if (calendarArray[calID].ends == true)
    {
        
        dn = getEnds(range,calID);
        a = dn[0];
        b = dn[1];
        
        var a_found = false;
        var b_found = false;
        
        for (var i=0;i<(calendarArray[calID].endsDates.length);i++)
        {
            if (a.toString()==calendarArray[calID].endsDates[i].toString())
                a_found = true;
            if (b.toString()==calendarArray[calID].endsDates[i].toString())
                b_found = true;   
            
        }
        
        if (a_found)
            calendarArray[calID].addRenderer((a.getMonth()+1)+'/'+a.getDate()+'/'+a.getFullYear(), calendarArray[calID].renderBodyCellPending_middle_left);
        else
        {  
            
            calendarArray[calID].endsDates[(calendarArray[calID].endsDates.length)] = a;
            calendarArray[calID].addRenderer((a.getMonth()+1)+'/'+a.getDate()+'/'+a.getFullYear(), calendarArray[calID].renderBodyCellPending_left);
        }
        if (b_found)
            calendarArray[calID].addRenderer((b.getMonth()+1)+'/'+b.getDate()+'/'+b.getFullYear(), calendarArray[calID].renderBodyCellPending_middle_right);
        else
        {  
            
            calendarArray[calID].endsDates[(calendarArray[calID].endsDates.length)] = b;
            calendarArray[calID].addRenderer((b.getMonth()+1)+'/'+b.getDate()+'/'+b.getFullYear(), calendarArray[calID].renderBodyCellPending_right);
        }          
        a = YAHOO.widget.DateMath.add(a, YAHOO.widget.DateMath.DAY, 1);
        b = YAHOO.widget.DateMath.subtract(b, YAHOO.widget.DateMath.DAY, 1);
        if (a <= b)//son mas de 2
            calendarArray[calID].addRenderer(getRange(a,b), calendarArray[calID].renderBodyCellPending);
            
    }
    else 
        calendarArray[calID].addRenderer(range, calendarArray[calID].renderBodyCellPending);   
}