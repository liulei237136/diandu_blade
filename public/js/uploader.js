!function(e,t){"function"==typeof define&&define.amd?define("simple-uploader",["jquery","simple-module"],(function(r,n){return e.uploader=t(r,n)})):"object"==typeof exports?module.exports=t(require("jquery"),require("simple-module")):(e.simple=e.simple||{},e.simple.uploader=t(jQuery,SimpleModule))}(this,(function(e,t){var r,n={}.hasOwnProperty;return r=function(t){function r(){return r.__super__.constructor.apply(this,arguments)}var o;return function(e,t){for(var r in t)n.call(t,r)&&(e[r]=t[r]);function o(){this.constructor=e}o.prototype=t.prototype,e.prototype=new o,e.__super__=t.prototype}(r,t),r.count=0,r.prototype.opts={url:"",params:null,fileKey:"upload_file",connectionCount:3},r.prototype._init=function(){var t;return this.files=[],this.queue=[],this.id=++r.count,this.on("uploadcomplete",(t=this,function(r,n){return t.files.splice(e.inArray(n,t.files),1),t.queue.length>0&&t.files.length<t.opts.connectionCount?t.upload(t.queue.shift()):t.uploading=!1})),e(window).on("beforeunload.uploader-"+this.id,function(e){return function(t){if(e.uploading)return t.originalEvent.returnValue=e._t("leaveConfirm"),e._t("leaveConfirm")}}(this))},r.prototype.generateId=(o=0,function(){return o+=1}),r.prototype.upload=function(t,r){var n,o,i,u;if(null==r&&(r={}),null!=t){if(e.isArray(t)||t instanceof FileList)for(o=0,u=t.length;o<u;o++)n=t[o],this.upload(n,r);else e(t).is("input:file")?((i=e(t).attr("name"))&&(r.fileKey=i),this.upload(e.makeArray(e(t)[0].files),r)):t.id&&t.obj||(t=this.getFile(t));if(t&&t.obj)if(e.extend(t,r),this.files.length>=this.opts.connectionCount)this.queue.push(t);else if(!1!==this.triggerHandler("beforeupload",[t]))return this.files.push(t),this._xhrUpload(t),this.uploading=!0}},r.prototype.getFile=function(e){var t,r,n;return e instanceof window.File||e instanceof window.Blob?(t=null!=(r=e.fileName)?r:e.name,{id:this.generateId(),url:this.opts.url,params:this.opts.params,fileKey:this.opts.fileKey,name:t,size:null!=(n=e.fileSize)?n:e.size,ext:t?t.split(".").pop().toLowerCase():"",obj:e}):null},r.prototype._xhrUpload=function(t){var r,n,o,i,u;if((r=new FormData).append(t.fileKey,t.obj),r.append("original_filename",t.name),t.params)for(n in o=t.params)i=o[n],r.append(n,i);return t.xhr=e.ajax({url:t.url,data:r,processData:!1,contentType:!1,type:"POST",headers:{"X-File-Name":encodeURIComponent(t.name)},xhr:function(){var t,r;return(t=e.ajaxSettings.xhr())&&(t.upload.onprogress=(r=this,function(e){return r.progress(e)})),t},progress:(u=this,function(e){if(e.lengthComputable)return u.trigger("uploadprogress",[t,e.loaded,e.total])}),error:function(e){return function(r,n,o){return e.trigger("uploaderror",[t,r,n])}}(this),success:function(r){return function(n){return r.trigger("uploadprogress",[t,t.size,t.size]),r.trigger("uploadsuccess",[t,n]),e(document).trigger("uploadsuccess",[t,n,r])}}(this),complete:function(e){return function(r,n){return e.trigger("uploadcomplete",[t,r.responseText])}}(this)})},r.prototype.cancel=function(e){var t,r,n,o;if(!e.id)for(r=0,n=(o=this.files).length;r<n;r++)if((t=o[r]).id===1*e){e=t;break}return this.trigger("uploadcancel",[e]),e.xhr&&e.xhr.abort(),e.xhr=null},r.prototype.readImageFile=function(t,r){var n,o;if(e.isFunction(r))return(o=new Image).onload=function(){return r(o)},o.onerror=function(){return r()},window.FileReader&&FileReader.prototype.readAsDataURL&&/^image/.test(t.type)?((n=new FileReader).onload=function(e){return o.src=e.target.result},n.readAsDataURL(t)):r()},r.prototype.destroy=function(){var t,r,n,o;for(this.queue.length=0,r=0,n=(o=this.files).length;r<n;r++)t=o[r],this.cancel(t);return e(window).off(".uploader-"+this.id),e(document).off(".uploader-"+this.id)},r.i18n={"zh-CN":{leaveConfirm:"正在上传文件，如果离开上传会自动取消"}},r.locale="zh-CN",r}(t),function(e){return new r(e)}}));
