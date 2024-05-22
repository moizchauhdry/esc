import{m as v,v as w,f as l,a as u,u as a,w as N,F as b,o as n,X as D,b as e,d as M,e as V,i as f,q as R,x,t as i,g as U,j}from"./app-f9a4442b.js";import{_ as E}from"./AuthenticatedLayout-3f6734d3.js";import{_ as y}from"./InputError-a26a38cb.js";const F={class:"page-wrapper"},$={class:"page-content"},B={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},L=e("div",{class:"breadcrumb-title pe-3"},"User Management",-1),I=e("div",{class:"ps-3"},[e("nav",{"aria-label":"breadcrumb"},[e("ol",{class:"breadcrumb mb-0 p-0"},[e("li",{class:"breadcrumb-item"},[e("a",{href:"javascript:;"},[e("i",{class:"bx bx-home-alt"})])]),e("li",{class:"breadcrumb-item active","aria-current":"page"},"Role & Permission")])])],-1),O={class:"ms-auto"},P={class:"col"},T=e("i",{class:"bx bx-plus"},null,-1),q={key:0,class:"modal fade show",id:"exampleLargeModal",tabindex:"-1","aria-hidden":"true",style:{display:"block"}},A={class:"modal-dialog modal-md"},X={class:"modal-content"},z=e("h5",{class:"modal-title"},"Role & Permission",-1),G={class:"modal-body"},H={class:"row g-3"},J={class:"col-md-12"},K=e("label",{for:"input13",class:"form-label"},"Role Name",-1),Q={class:"position-relative input-icon"},W=e("span",{class:"position-absolute top-50 translate-middle-y"},[e("i",{class:"bx bx-user"})],-1),Y={class:"col-md-12"},Z=e("label",{for:"input13",class:"form-label"},"Role Name",-1),ee=["value"],se={class:"form-check-label",for:"flexCheckDefault"},te={class:"modal-footer"},ae={type:"submit",class:"btn btn-primary btn-sm"},oe={class:"card"},le={class:"card-body"},ne={class:"table-responsive"},ie={id:"example",class:"table table-striped table-bordered",style:{width:"100%"}},de=e("thead",null,[e("tr",null,[e("th",null,"ID"),e("th",null,"Name"),e("th",null,"Created Date"),e("th",null,"Updated Date"),e("td")])],-1),ce=["onClick"],re=e("i",{class:"bx bx-edit"},null,-1),me=[re],he={__name:"Index",props:{roles:Object,permissions:Object},setup(_){const d=v(!1),c=v(!1),s=w({id:"",name:"",permissions:[]}),g=()=>{d.value=!0,c.value=!1},k=()=>{s.post(route("role.create"),{preserveScroll:!0,onSuccess:()=>r(),onError:()=>p(),onFinish:()=>{}})},C=m=>{d.value=!0,c.value=!0,s.id=m.id,s.name=m.name,s.permissions=m.permissions},S=()=>{s.post(route("role.update"),{preserveScroll:!0,onSuccess:()=>r(),onError:()=>p(),onFinish:()=>{}})},p=()=>{},r=()=>{d.value=!1,s.reset()};return(m,o)=>(n(),l(b,null,[u(a(D),{title:"Roles"}),u(E,null,{default:N(()=>[e("div",F,[e("div",$,[e("div",B,[L,I,e("div",O,[e("div",P,[e("button",{type:"button",class:"btn btn-primary btn-sm","data-bs-toggle":"modal","data-bs-target":"#exampleLargeModal",onClick:g},[T,M("Add")]),d.value?(n(),l("div",q,[e("div",A,[e("div",X,[e("form",{onSubmit:o[2]||(o[2]=V(t=>c.value?S():k(),["prevent"]))},[e("div",{class:"modal-header"},[z,e("button",{type:"button",class:"btn-close","data-bs-dismiss":"modal","aria-label":"Close",onClick:r})]),e("div",G,[e("div",H,[e("div",J,[K,e("div",Q,[f(e("input",{type:"text",class:"form-control",id:"input13",placeholder:"Name","onUpdate:modelValue":o[0]||(o[0]=t=>a(s).name=t)},null,512),[[R,a(s).name]]),W]),u(y,{message:a(s).errors.name},null,8,["message"])]),e("div",Y,[Z,(n(!0),l(b,null,x(_.permissions,t=>(n(),l("div",{key:t.id,class:"form-check"},[f(e("input",{class:"form-check-input",type:"checkbox",value:t.id,id:"flexCheckDefault","onUpdate:modelValue":o[1]||(o[1]=h=>a(s).permissions=h)},null,8,ee),[[j,a(s).permissions]]),e("label",se,i(t.name),1)]))),128)),u(y,{message:a(s).errors.permissions},null,8,["message"])])])]),e("div",te,[e("button",{type:"button",class:"btn btn-secondary btn-sm","data-bs-dismiss":"modal",onClick:r},"Close"),e("button",ae,i(c.value?"Save & Update":"Save & Submit"),1)])],32)])])])):U("",!0)])])]),e("div",oe,[e("div",le,[e("div",ne,[e("table",ie,[de,e("tbody",null,[(n(!0),l(b,null,x(_.roles.data,(t,h)=>(n(),l("tr",null,[e("td",null,i(t.id),1),e("td",null,i(t.name),1),e("td",null,i(t.created_at),1),e("td",null,i(t.updated_at),1),e("td",null,[e("button",{type:"button",onClick:ue=>C(t),title:"Edit",clas:"btn btn-primary"},me,8,ce)])]))),256))])])])])])])])]),_:1})],64))}};export{he as default};
