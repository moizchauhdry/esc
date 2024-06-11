import{J as k,v as S,f as o,a as r,u as l,w as h,F as b,o as s,X as D,b as t,t as d,d as n,l as m,g as a,e as B,i as y,q as g,n as P,z as A,c as x}from"./app-06c6cc13.js";import{_ as C}from"./AuthenticatedLayout-3cd2b99f.js";import{_ as F}from"./PrimaryButton-1c2e4429.js";import{P as V}from"./Paginate-5eda1ff8.js";import{_ as j}from"./SuccessButton-3a4d9b3a.js";import"./_plugin-vue_export-helper-c27b6911.js";const I={class:"page-wrapper"},N={class:"page-content"},z={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},L=t("div",{class:"breadcrumb-title pe-3"},"Manage Shipments",-1),M={class:"ps-3"},O={"aria-label":"breadcrumb"},R={class:"breadcrumb mb-0 p-0"},T=t("li",{class:"breadcrumb-item"},[t("a",{href:"javascript:;"},[t("i",{class:"bx bx-home-alt"})])],-1),U={class:"breadcrumb-item active","aria-current":"page"},W={class:"text-capitalize"},$={key:0,class:"ms-auto"},E={class:"card"},q={class:"card-body"},J=["onSubmit"],K={class:"row mb-3"},X={class:"col-md-3"},G={class:"col-md-3"},H={class:"col-md-3"},Q={class:"table-responsive"},Y={class:"table"},Z={class:"table-light"},tt=t("th",{style:{width:"5px"}},"SR #",-1),et=t("th",{style:{width:"10px"}},"AWB/Shipment #",-1),st=t("th",{style:{width:"10px"}},"Shipper/Consignee",-1),it={key:0,style:{width:"10px"}},ot={key:1,style:{width:"10px"}},nt={key:2,style:{width:"10px"}},lt={key:3,style:{width:"10px"}},at=t("th",{style:{width:"10px"}},"Status",-1),dt=t("th",{style:{width:"10px"}},"Actions",-1),ct={style:{width:"10px"}},_t={class:"d-flex align-items-center"},rt=t("div",null,[t("input",{class:"form-check-input me-3",type:"checkbox",value:"1","aria-label":"..."})],-1),ht={style:{width:"10px"}},ut=t("b",null,"AWB #:",-1),pt=t("br",null,null,-1),mt=t("b",null,"Shipment #:",-1),bt=t("br",null,null,-1),yt=t("b",null,"Company:",-1),gt=t("br",null,null,-1),xt={style:{width:"10px"}},ft=t("b",null,"Shipper:",-1),vt=t("br",null,null,-1),wt=t("b",null,"Consignee:",-1),kt=t("br",null,null,-1),St={key:0,style:{width:"10px"}},Dt=t("b",null,"Port:",-1),Bt=t("br",null,null,-1),Pt=t("b",null,"Date:",-1),At={key:1,style:{width:"10px"}},Ct=t("b",null,"Port:",-1),Ft=t("br",null,null,-1),Vt=t("b",null,"Date:",-1),jt={key:2,style:{width:"10px"}},It={key:3,style:{width:"10px"}},Nt={style:{width:"10px"}},zt={key:0,class:"badge text-warning bg-light-warning p-2 text-uppercase px-2"},Lt=t("i",{class:"bx bxs-circle me-1"},null,-1),Mt={key:1,class:"badge text-success bg-light-success p-2 text-uppercase px-2"},Ot=t("i",{class:"bx bxs-circle me-1"},null,-1),Rt={key:2,class:"badge text-danger bg-light-danger p-2 text-uppercase px-2"},Tt=t("i",{class:"bx bxs-circle me-1"},null,-1),Ut={style:{width:"10px"}},Wt={class:"d-flex order-actions"},$t=t("i",{class:"bx bxs-edit"},null,-1),Et=t("i",{class:"bx bxs-edit"},null,-1),qt=t("i",{class:"bx bxs-collection"},null,-1),Jt=["href"],Kt=t("i",{class:"bx bxs-printer"},null,-1),Xt=[Kt],Gt={class:"card-body"},Ht={class:"float-right"},ie={__name:"Index",props:{invoices:Object,contact:Object,page_type:String,filter:Object},setup(i){const u=k().props.can,f=c=>new Intl.NumberFormat("en-US",{minimumFractionDigits:2,maximumFractionDigits:2}).format(c),_=S({invoice_id:"",mawb_no:""}),v=()=>{_.post(route("invoice.index"),{preserveScroll:!0,onSuccess:c=>{},onError:c=>{console.log(c)},onFinish:()=>{}})};return(c,p)=>(s(),o(b,null,[r(l(D),{title:"Invoices"}),r(C,null,{default:h(()=>[t("div",I,[t("div",N,[t("div",z,[L,t("div",M,[t("nav",O,[t("ol",R,[T,t("li",U,[t("span",W,d(i.page_type),1),n(" List")])])])]),i.page_type=="shipment"&&l(u).shipment_create?(s(),o("div",$,[r(l(m),{href:c.route("shipment.create")},{default:h(()=>[r(F,null,{default:h(()=>[n("Add "+d(i.page_type),1)]),_:1})]),_:1},8,["href"])])):a("",!0)]),t("div",E,[t("div",q,[t("form",{onSubmit:B(v,["prevent"])},[t("div",K,[t("div",X,[y(t("input",{type:"text","onUpdate:modelValue":p[0]||(p[0]=e=>l(_).invoice_id=e),class:"form-control",placeholder:"Search Invoice #"},null,512),[[g,l(_).invoice_id]])]),t("div",G,[y(t("input",{type:"text","onUpdate:modelValue":p[1]||(p[1]=e=>l(_).mawb_no=e),class:"form-control",placeholder:"Search AWB #"},null,512),[[g,l(_).mawb_no]])]),t("div",H,[r(j,{class:P(["px-4 py-1",{"opacity-25":l(_).processing}]),disabled:l(_).processing},{default:h(()=>[n(" Search ")]),_:1},8,["class","disabled"])])])],40,J),t("div",Q,[t("table",Y,[t("thead",Z,[t("tr",null,[tt,et,st,i.page_type=="shipment"?(s(),o("th",it,"Departure")):a("",!0),i.page_type=="shipment"?(s(),o("th",ot,"Landing")):a("",!0),i.page_type=="invoice"?(s(),o("th",nt,"Total")):a("",!0),i.page_type=="invoice"?(s(),o("th",lt,"Invoice Date")):a("",!0),at,dt])]),t("tbody",null,[(s(!0),o(b,null,A(i.invoices.data,(e,w)=>(s(),o("tr",null,[t("td",ct,[t("div",_t,[rt,n(" "+d(++w),1)])]),t("td",ht,[ut,n(" "+d(e.mawb_no)+" ",1),pt,mt,n(" "+d(e.id)+" ",1),bt,yt,n(" "+d(e.company_name)+" ",1),gt]),t("td",xt,[ft,n(" "+d(e.shipper_name)+" ",1),vt,wt,n(" "+d(e.consignee_name)+" ",1),kt]),i.page_type=="shipment"?(s(),o("td",St,[Dt,n(" "+d(e.sender)+" ",1),Bt,Pt,n(" "+d(e.departure_at),1)])):a("",!0),i.page_type=="shipment"?(s(),o("td",At,[Ct,n(" "+d(e.destination)+" ",1),Ft,Vt,n(" "+d(e.landing_at),1)])):a("",!0),i.page_type=="invoice"?(s(),o("td",jt,"PKR "+d(f(e.total)),1)):a("",!0),i.page_type=="invoice"?(s(),o("td",It,d(e.invoice_at),1)):a("",!0),t("td",Nt,[e.status_id==1?(s(),o("div",zt,[Lt,n("Pending ")])):a("",!0),e.status_id==2?(s(),o("div",Mt,[Ot,n("Approved ")])):a("",!0),e.status_id==3?(s(),o("div",Rt,[Tt,n("Rejected ")])):a("",!0)]),t("td",Ut,[t("div",Wt,[i.page_type=="shipment"&&l(u).shipment_update?(s(),x(l(m),{key:0,href:c.route("shipment.edit",e.id)},{default:h(()=>[$t]),_:2},1032,["href"])):a("",!0),i.page_type=="invoice"&&l(u).invoice_update?(s(),x(l(m),{key:1,href:c.route("invoice.edit",e.id)},{default:h(()=>[Et]),_:2},1032,["href"])):a("",!0),r(l(m),{href:c.route("invoice.detail",e.id),title:"Detail",class:"ms-1"},{default:h(()=>[qt]),_:2},1032,["href"]),i.page_type=="invoice"&&l(u).invoice_print?(s(),o("a",{key:2,href:c.route("invoice.print",e.id),title:"Print",class:"ms-1",target:"_blank"},Xt,8,Jt)):a("",!0)])])]))),256))])])])]),t("div",Gt,[t("div",Ht,[r(V,{links:i.invoices.links},null,8,["links"])])])])])])]),_:1})],64))}};export{ie as default};
