import{_ as R}from"./AuthenticatedLayout-cb2df174.js";import{J as D,f as r,a as i,u as p,w as f,F as v,o,X as w,b as t,c as C,A as g,B as P,g as S,C as B,d as x,t as e,z as F}from"./app-3fd9687c.js";import I from"./Filter-0c2b7946.js";import O from"./Payment-fee22481.js";import{_ as $}from"./PrimaryButton-14819249.js";import"./SecondaryButton-27398031.js";import"./SuccessButton-4fabde40.js";import"./InputLabel-03840cc9.js";import"./InputError-62683f20.js";import"./main-a153b9b7.js";import"./moment-a9aaa855.js";const j={class:"page-wrapper"},k={class:"page-content"},L={class:"page-breadcrumb d-none d-sm-flex align-items-center mb-3"},N=t("div",{class:"breadcrumb-title pe-3"},"Invoice Management",-1),V=t("div",{class:"ps-3"},[t("nav",{"aria-label":"breadcrumb"},[t("ol",{class:"breadcrumb mb-0 p-0"},[t("li",{class:"breadcrumb-item"},[t("a",{href:"javascript:;"},[t("i",{class:"bx bx-home-alt"})])]),t("li",{class:"breadcrumb-item active","aria-current":"page"},"Ledger List")])])],-1),A={class:"ms-auto"},E=["href"],z=t("i",{class:"bx bxs-printer text-white"},null,-1),G={class:"card"},T={class:"card-body"},U=t("div",{class:"d-lg-flex align-items-center mb-4 gap-3"},[t("div",{class:"position-relative"},[t("input",{type:"text",class:"form-control ps-5 radius-30",placeholder:"Search Invoice"}),t("span",{class:"position-absolute top-50 product-show translate-middle-y"},[t("i",{class:"bx bx-search"})])])],-1),X={class:"table-responsive"},q={class:"table table-bordered ledger-table table-sm",style:{"font-size":"12px"}},J={class:"table-light"},K={colspan:"12",style:{"text-align":"center"}},M=t("br",null,null,-1),W={colspan:"12",style:{"text-align":"center"}},H=t("tr",null,[t("th",null,"Date"),t("th",null,"Airline"),t("th",null,"Particulars"),t("th",null,"Orig"),t("th",null,"Dest"),t("th",null,"Pieces"),t("th",null,"Weight"),t("th",null,"Invoice ID"),t("th",null,"Debit"),t("th",null,"Credit"),t("th",null,"Balance"),t("th",null,"D/C")],-1),Q=t("th",{colspan:"8",class:"text-right"},"Total",-1),ut={__name:"Index",props:{ledgers:Object,companies:Object,filter:Object,balance:Object},setup(a){const y=D().props.auth.user.roles[0],s=n=>new Intl.NumberFormat("en-US",{minimumFractionDigits:2,maximumFractionDigits:2}).format(n);return(n,Y)=>(o(),r(v,null,[i(p(w),{title:"Ledgers"}),i(R,null,{default:f(()=>[t("div",j,[t("div",k,[t("div",L,[N,V,t("div",A,[p(y).id!=2?(o(),C(O,g(P({key:0},n.$props)),null,16)):S("",!0),i(I,g(B(n.$props)),null,16),t("a",{href:n.route("ledger.print",a.filter),title:"Print",class:"ms-1",target:"_blank"},[i($,null,{default:f(()=>[z]),_:1})],8,E)])]),t("div",G,[t("div",T,[U,t("div",X,[t("table",q,[t("thead",J,[t("tr",null,[t("th",K,[x(e(a.filter.company_name??"EXPRESS SAVER CARGO")+" ",1),M,x(" CURR: PKR/RS ")])]),t("tr",null,[t("th",W,"General Ledger From "+e(a.filter.from)+" to "+e(a.filter.to),1)]),H]),t("tbody",null,[(o(!0),r(v,null,F(a.ledgers.data,(l,Z)=>{var c,d,u,m,_,h,b;return o(),r("tr",null,[t("td",null,e(l.invoice_at),1),t("td",null,e((c=l.invoice)==null?void 0:c.carrier),1),t("td",null,e((d=l.invoice)==null?void 0:d.mawb_no),1),t("td",null,e((u=l.invoice)==null?void 0:u.sender),1),t("td",null,e((m=l.invoice)==null?void 0:m.destination),1),t("td",null,e((_=l.invoice)==null?void 0:_.quantity),1),t("td",null,e((h=l.invoice)==null?void 0:h.weight),1),t("td",null,e((b=l.invoice)==null?void 0:b.id),1),t("td",null,e(s(l.debit)),1),t("td",null,e(s(l.credit)),1),t("td",null,e(s(l.balance)),1),t("td",null,e(l.credit>0?"CR":"DR"),1)])}),256)),t("tr",null,[Q,t("th",null,e(s(a.balance.debit_total)),1),t("th",null,e(s(a.balance.credit_total)),1),t("th",null,e(s(a.balance.balance_total)),1)])])])])])])])])]),_:1})],64))}};export{ut as default};
