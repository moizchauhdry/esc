import{_ as g}from"./AuthenticatedLayout-c02d33d1.js";import{J as k,p as y,f as l,a as o,u as d,w as m,F as u,o as n,X as D,b as t,q as E,s as $,x as F,t as a,y as C,g as P,v as w}from"./app-3e0b7936.js";import{P as I}from"./Paginate-87761236.js";import{_ as N}from"./ActionButton-4f67e7b2.js";import S from"./Create-e4d1dd62.js";import Y from"./Filter-5cbe9149.js";import{h as M}from"./moment-a9aaa855.js";/* empty css                                                         */import"./index-d1a625ba.js";import"./_plugin-vue_export-helper-c27b6911.js";import"./SecondaryButton-33bc4454.js";import"./SuccessButton-94fc99e1.js";import"./InputLabel-f5fcd561.js";import"./InputError-f47b5412.js";import"./PrimaryButton-8503865a.js";const A={class:"page-wrapper"},B={class:"page-content"},R={class:"page-breadcrumb d-sm-flex align-items-center mb-3"},V=t("div",{class:"breadcrumb-title pe-3"},"Manage Expenses",-1),j=t("div",{class:"ps-3"},[t("nav",{"aria-label":"breadcrumb"},[t("ol",{class:"breadcrumb mb-0 p-0"},[t("li",{class:"breadcrumb-item"},[t("a",{href:"javascript:;"},[t("i",{class:"bx bx-home-alt"})])]),t("li",{class:"breadcrumb-item active","aria-current":"page"},"Expense List")])])],-1),L={class:"ms-auto"},O={class:"card"},T={class:"card-body"},q={class:"table-responsive"},z={class:"table"},J={class:"table-light"},K={colspan:"17",class:"text-uppercase text-center text-lg"},U=t("tr",{class:"text-uppercase"},[t("th",null,"SR #"),t("th",null,"Expense ID"),t("th",null,"Year"),t("th",null,"Month"),t("th",null,"Expense Date"),t("th",null,"No.of Items"),t("th",null,"Total Amount (PKR)"),t("th")],-1),X=t("i",{class:"bx bx-edit"},null,-1),G=["onClick"],H=t("i",{class:"bx bx-trash"},null,-1),Q=[H],W={class:"card-body"},Z={class:"float-right"},ht={__name:"Index",props:{expenses:Array,filter:Object},setup(r){const _=k().props.can,c=y(null),p=s=>{c.value.edit(s)},h=s=>new Intl.NumberFormat("en-US",{minimumFractionDigits:2,maximumFractionDigits:2}).format(s),f=s=>{const i=w({expense_id:s});confirm("Are you sure you want to delete this Expense?")&&i.post(route("expense.delete"),{preserveScroll:!0,onSuccess:e=>{},onError:e=>{},onFinish:()=>{}})},b=s=>M(s).format("YYYY-MM-DD");return(s,i)=>(n(),l(u,null,[o(d(D),{title:"Invoices"}),o(g,null,{default:m(()=>[t("div",A,[t("div",B,[t("div",R,[V,j,t("div",L,[o(Y,E($(s.$props)),null,16),o(S,F(s.$props,{ref_key:"create_edit_ref",ref:c}),null,16)])]),t("div",O,[t("div",T,[t("div",q,[t("table",z,[t("thead",J,[t("tr",null,[t("th",K,' From "'+a(r.filter.from_date)+'" TO "'+a(r.filter.to_date)+'" ',1)]),U]),t("tbody",null,[(n(!0),l(u,null,C(r.expenses.data,(e,x)=>(n(),l("tr",null,[t("td",null,a(++x),1),t("td",null,a(e.id),1),t("td",null,a(e.year),1),t("td",null,a(e.month_name),1),t("td",null,a(b(e.expense_at)),1),t("td",null,a(e.items_count),1),t("td",null,a(h(e.total_amount)),1),t("td",null,[o(N,{onClick:v=>p(e),title:"Edit",class:"mr-1"},{default:m(()=>[X]),_:2},1032,["onClick"]),d(_).expense_delete?(n(),l("a",{key:0,class:"text-danger text-lg",href:"#",onClick:v=>f(e.id)},Q,8,G)):P("",!0)])]))),256))])])])]),t("div",W,[t("div",Z,[o(I,{links:r.expenses.links},null,8,["links"])])])])])])]),_:1})],64))}};export{ht as default};
