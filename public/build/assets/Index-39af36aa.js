import{_ as h}from"./AuthenticatedLayout-3f6734d3.js";import{f as c,a,u as i,w as n,F as r,o as d,X as b,b as s,l as _,d as l,x as m,t as e}from"./app-f9a4442b.js";import{_ as p}from"./PrimaryButton-5d531543.js";const f={class:"page-wrapper"},x={class:"page-content"},g={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},v=s("div",{class:"breadcrumb-title pe-3"},"Invoice Management",-1),y=s("div",{class:"ps-3"},[s("nav",{"aria-label":"breadcrumb"},[s("ol",{class:"breadcrumb mb-0 p-0"},[s("li",{class:"breadcrumb-item"},[s("a",{href:"javascript:;"},[s("i",{class:"bx bx-home-alt"})])]),s("li",{class:"breadcrumb-item active","aria-current":"page"},"Invoice List")])])],-1),I={class:"ms-auto"},D={class:"card"},N={class:"card-body"},w=s("div",{class:"d-lg-flex align-items-center mb-4 gap-3"},[s("div",{class:"position-relative"},[s("input",{type:"text",class:"form-control ps-5 radius-30",placeholder:"Search Invoice"}),s("span",{class:"position-absolute top-50 product-show translate-middle-y"},[s("i",{class:"bx bx-search"})])])],-1),A={class:"table-responsive"},S={class:"table"},j=s("thead",{class:"table-light"},[s("tr",null,[s("th",null,"Invoice #"),s("th",null,"Company"),s("th",null,"Shipper"),s("th",null,"Consignee"),s("th",null,"Status"),s("th",null,"Total"),s("th",null,"Date"),s("th",null,"Actions")])],-1),k={class:"d-flex align-items-center"},B={class:"ms-2"},C={class:"mb-0 font-14"},V=s("b",null,"Account #:",-1),F=s("br",null,null,-1),L=s("b",null,"Name:",-1),O=s("br",null,null,-1),P=s("b",null,"Account #:",-1),T=s("br",null,null,-1),$=s("b",null,"Name:",-1),E=s("br",null,null,-1),K=s("td",null,[s("div",{class:"badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"},[s("i",{class:"bx bxs-circle me-1"}),l("Done ")])],-1),M={class:"d-flex order-actions"},R=s("i",{class:"bx bxs-edit"},null,-1),X=s("a",{href:"#",title:"Detail",class:"ms-1"},[s("i",{class:"bx bxs-collection"})],-1),q=["href"],z=s("i",{class:"bx bxs-printer"},null,-1),G=[z],H=s("a",{href:"#",title:"Delete",class:"ms-1 text-danger"},[s("i",{class:"bx bxs-trash"})],-1),Z={__name:"Index",props:{invoices:Object,contact:Object},setup(u){return(o,J)=>(d(),c(r,null,[a(i(b),{title:"Invoices"}),a(h,null,{default:n(()=>[s("div",f,[s("div",x,[s("div",g,[v,y,s("div",I,[a(i(_),{href:o.route("invoice.create")},{default:n(()=>[a(p,null,{default:n(()=>[l("Add Invoice")]),_:1})]),_:1},8,["href"])])]),s("div",D,[s("div",N,[w,s("div",A,[s("table",S,[j,s("tbody",null,[(d(!0),c(r,null,m(u.invoices.data,(t,Q)=>(d(),c("tr",null,[s("td",null,[s("div",k,[s("div",B,[s("h6",C,"000"+e(t.id),1)])])]),s("td",null,e(t.company_name),1),s("td",null,[V,l(" "+e(t.data.shipper_id)+" ",1),F,L,l(" "+e(t.consignee_name)+" ",1),O]),s("td",null,[P,l(" "+e(t.data.consignee_id)+" ",1),T,$,l(" "+e(t.consignee_name)+" ",1),E]),K,s("td",null,"PKR "+e(t.data.total),1),s("td",null,e(t.created_at),1),s("td",null,[s("div",M,[a(i(_),{href:o.route("invoice.edit",t.id)},{default:n(()=>[R]),_:2},1032,["href"]),X,s("a",{href:o.route("invoice.print",t.id),title:"Print",class:"ms-1",target:"_blank"},G,8,q),H])])]))),256))])])])])])])])]),_:1})],64))}};export{Z as default};
