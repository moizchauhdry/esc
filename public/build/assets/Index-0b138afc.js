import{_ as g}from"./AuthenticatedLayout-0d7f1b7d.js";import{J as y,f as i,a as h,u as c,w as d,F as p,o as l,X as x,b as t,t as e,d as a,l as u,g as o,y as f,c as b}from"./app-c19afc6b.js";import{_ as v}from"./PrimaryButton-baff175d.js";const k={class:"page-wrapper"},S={class:"page-content"},w={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},A=t("div",{class:"breadcrumb-title pe-3"},"Manage Shipments",-1),B={class:"ps-3"},D={"aria-label":"breadcrumb"},N={class:"breadcrumb mb-0 p-0"},C=t("li",{class:"breadcrumb-item"},[t("a",{href:"javascript:;"},[t("i",{class:"bx bx-home-alt"})])],-1),I={class:"breadcrumb-item active","aria-current":"page"},P={class:"text-capitalize"},V={key:0,class:"ms-auto"},j={class:"card"},L={class:"card-body"},T=t("div",{class:"d-lg-flex align-items-center mb-4 gap-3"},[t("div",{class:"position-relative"},[t("input",{type:"text",class:"form-control ps-5 radius-30",placeholder:"Search Invoice"}),t("span",{class:"position-absolute top-50 product-show translate-middle-y"},[t("i",{class:"bx bx-search"})])])],-1),F={class:"table-responsive"},O={class:"table"},R={class:"table-light"},W=t("th",null,"SR #",-1),$=t("th",null,"AWB #",-1),z=t("th",null,"Company",-1),E=t("th",null,"Shipper",-1),J=t("th",null,"Consignee",-1),K={key:0},M={key:1},X={key:2},q={key:3},G=t("th",null,"Type/Status",-1),H=t("th",null,"Actions",-1),Q={class:"d-flex align-items-center"},U=t("div",null,[t("input",{class:"form-check-input me-3",type:"checkbox",value:"1","aria-label":"..."})],-1),Y=t("b",null,"AWB #:",-1),Z=t("br",null,null,-1),tt=t("b",null,"Shipment #:",-1),et=t("b",null,"Account #:",-1),st=t("br",null,null,-1),nt=t("b",null,"Name:",-1),lt=t("br",null,null,-1),at=t("b",null,"Account #:",-1),it=t("br",null,null,-1),ot=t("b",null,"Name:",-1),ct=t("br",null,null,-1),dt={key:0},_t=t("b",null,"Port:",-1),rt=t("br",null,null,-1),ht=t("b",null,"Date:",-1),ut={key:1},pt=t("b",null,"Port:",-1),bt=t("br",null,null,-1),mt=t("b",null,"Date:",-1),gt={key:2},yt={key:3},xt={class:"badge text-primary bg-light-primary p-2 text-uppercase px-2 mx-1"},ft=t("i",{class:"bx bxs-circle me-1"},null,-1),vt=t("div",{class:"badge text-warning bg-light-warning p-2 text-uppercase px-2"},[t("i",{class:"bx bxs-circle me-1"}),a("open ")],-1),kt={class:"d-flex order-actions"},St=t("i",{class:"bx bxs-edit"},null,-1),wt=t("i",{class:"bx bxs-edit"},null,-1),At=t("a",{href:"#",title:"Detail",class:"ms-1"},[t("i",{class:"bx bxs-collection"})],-1),Bt=["href"],Dt=t("i",{class:"bx bxs-printer"},null,-1),Nt=[Dt],jt={__name:"Index",props:{invoices:Object,contact:Object,page_type:String},setup(s){const _=y().props.can;return(r,Ct)=>(l(),i(p,null,[h(c(x),{title:"Invoices"}),h(g,null,{default:d(()=>[t("div",k,[t("div",S,[t("div",w,[A,t("div",B,[t("nav",D,[t("ol",N,[C,t("li",I,[t("span",P,e(s.page_type),1),a(" List")])])])]),s.page_type=="shipment"&&c(_).shipment_create?(l(),i("div",V,[h(c(u),{href:r.route("shipment.create")},{default:d(()=>[h(v,null,{default:d(()=>[a("Add "+e(s.page_type),1)]),_:1})]),_:1},8,["href"])])):o("",!0)]),t("div",j,[t("div",L,[T,t("div",F,[t("table",O,[t("thead",R,[t("tr",null,[W,$,z,E,J,s.page_type=="shipment"?(l(),i("th",K,"Departure")):o("",!0),s.page_type=="shipment"?(l(),i("th",M,"Landing")):o("",!0),s.page_type=="invoice"?(l(),i("th",X,"Total")):o("",!0),s.page_type=="invoice"?(l(),i("th",q,"Invoice Date")):o("",!0),G,H])]),t("tbody",null,[(l(!0),i(p,null,f(s.invoices.data,(n,m)=>(l(),i("tr",null,[t("td",null,[t("div",Q,[U,a(" "+e(++m),1)])]),t("td",null,[Y,a(" "+e(n.mawb_no)+" ",1),Z,tt,a(" "+e(n.id),1)]),t("td",null,e(n.company_name),1),t("td",null,[et,a(" "+e(n.shipper_id)+" ",1),st,nt,a(" "+e(n.consignee_name)+" ",1),lt]),t("td",null,[at,a(" "+e(n.consignee_id)+" ",1),it,ot,a(" "+e(n.consignee_name)+" ",1),ct]),s.page_type=="shipment"?(l(),i("td",dt,[_t,a(" "+e(n.sender)+" ",1),rt,ht,a(" "+e(n.departure_at),1)])):o("",!0),s.page_type=="shipment"?(l(),i("td",ut,[pt,a(" "+e(n.destination)+" ",1),bt,mt,a(" "+e(n.landing_at),1)])):o("",!0),s.page_type=="invoice"?(l(),i("td",gt,"PKR "+e(n.total),1)):o("",!0),s.page_type=="invoice"?(l(),i("td",yt,e(n.invoice_at),1)):o("",!0),t("td",null,[t("div",xt,[ft,a(e(s.page_type),1)]),vt]),t("td",null,[t("div",kt,[s.page_type=="shipment"&&c(_).shipment_update?(l(),b(c(u),{key:0,href:r.route("shipment.edit",n.id)},{default:d(()=>[St]),_:2},1032,["href"])):o("",!0),s.page_type=="invoice"&&c(_).invoice_update?(l(),b(c(u),{key:1,href:r.route("invoice.edit",n.id)},{default:d(()=>[wt]),_:2},1032,["href"])):o("",!0),At,s.page_type=="invoice"&&c(_).invoice_print?(l(),i("a",{key:2,href:r.route("invoice.print",n.id),title:"Print",class:"ms-1",target:"_blank"},Nt,8,Bt)):o("",!0)])])]))),256))])])])])])])])]),_:1})],64))}};export{jt as default};
