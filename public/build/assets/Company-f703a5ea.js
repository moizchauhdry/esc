import{_ as m}from"./AuthenticatedLayout-428b6dd4.js";import{f as s,a as t,u as n,w as d,F as r,o as l,X as u,b as e,z as b,t as i,l as _,d as p}from"./app-d34879be.js";const h={class:"page-wrapper"},v={class:"page-content"},f=e("div",{class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},[e("div",{class:"breadcrumb-title pe-3"},"Invoice Management"),e("div",{class:"ps-3"},[e("nav",{"aria-label":"breadcrumb"},[e("ol",{class:"breadcrumb mb-0 p-0"},[e("li",{class:"breadcrumb-item"},[e("a",{href:"javascript:;"},[e("i",{class:"bx bx-home-alt"})])]),e("li",{class:"breadcrumb-item active","aria-current":"page"},"Company List")])])])],-1),g={class:"card"},x={class:"card-body"},y={class:"table-responsive"},C={id:"example",class:"table table-striped table-bordered",style:{width:"100%"}},w=e("thead",null,[e("tr",null,[e("th",null,"Company Id."),e("th",null,"Company Name"),e("th",null,"Action")])],-1),N=e("i",{class:"bx bxs-edit"},null,-1),B=e("div",{class:"card-body"},[e("div",{class:"float-right"})],-1),F={__name:"Company",props:{companies:Object},setup(c){return(o,L)=>(l(),s(r,null,[t(n(u),{title:"Company"}),t(m,null,{default:d(()=>[e("div",h,[e("div",v,[f,e("div",g,[e("div",x,[e("div",y,[e("table",C,[w,e("tbody",null,[(l(!0),s(r,null,b(c.companies,(a,V)=>(l(),s("tr",null,[e("td",null,i(a.id),1),e("td",null,i(a.name),1),e("td",null,[t(n(_),{href:o.route("ledger.index",{company:a.id})},{default:d(()=>[N,p(" Ledger ")]),_:2},1032,["href"])])]))),256))])])])]),B])])])]),_:1})],64))}};export{F as default};
