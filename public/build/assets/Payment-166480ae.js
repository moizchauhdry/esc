import{m as y,J as b,v as S,f as m,a as o,w as r,F as g,o as d,d as _,b as s,i as u,p as V,u as a,y as k,q as h,n as B,e as M,t as A}from"./app-5b1b29db.js";import{_ as F,a as N}from"./SecondaryButton-183bff0c.js";import{_ as P}from"./PrimaryButton-714da7bd.js";import{_ as U}from"./SuccessButton-53f8b47f.js";import{_ as p}from"./InputLabel-c034fd57.js";import{_ as f}from"./InputError-bc60c58c.js";import"./main-7a595266.js";const D={class:"p-6"},E=s("h2",{class:"text-lg font-medium text-gray-900"},"Legder Payment",-1),L=s("hr",null,null,-1),T={class:"mt-6"},j={class:"row g-2"},q={class:"col-md-6"},z=["value"],J={class:"col-md-3"},G={class:"col-md-3"},H={class:"mt-6 flex justify-end"},Z={__name:"Payment",props:{companies:Array,balance:Array},setup(I){const c=y(!1),v=y(!1),x=b().props.companies,C=b().props.balance,e=S({company_id:"",balance_total:C.balance_total,credit:""}),w=()=>{c.value=!0,v.value=!1},$=()=>{e.post(route("ledger.payment"),{preserveScroll:!0,onSuccess:n=>{i()},onError:n=>{console.log(n)},onFinish:()=>{}})},i=()=>{c.value=!1,e.reset()};return(n,l)=>(d(),m(g,null,[o(P,{onClick:w,type:"button"},{default:r(()=>[_("Payment")]),_:1}),o(F,{show:c.value,onClose:i},{default:r(()=>[s("form",{onSubmit:l[3]||(l[3]=M(t=>v.value?n.update():$(),["prevent"]))},[s("div",D,[E,L,s("div",T,[s("div",j,[s("div",q,[o(p,{for:"",value:"Company",class:"mb-1"}),u(s("select",{"onUpdate:modelValue":l[0]||(l[0]=t=>a(e).company_id=t),class:"form-control"},[(d(!0),m(g,null,k(a(x),t=>(d(),m("option",{value:t.id},A(t.name),9,z))),256))],512),[[V,a(e).company_id]]),o(f,{message:a(e).errors.company_id},null,8,["message"])]),s("div",J,[o(p,{for:"",value:"Balance",class:"mb-1"}),u(s("input",{type:"text",class:"form-control","onUpdate:modelValue":l[1]||(l[1]=t=>a(e).balance_total=t)},null,512),[[h,a(e).balance_total]]),o(f,{message:a(e).errors.balance_total},null,8,["message"])]),s("div",G,[o(p,{for:"",value:"Credit Amount",class:"mb-1"}),u(s("input",{type:"text",class:"form-control","onUpdate:modelValue":l[2]||(l[2]=t=>a(e).credit=t)},null,512),[[h,a(e).credit]]),o(f,{message:a(e).errors.credit},null,8,["message"])])])]),s("div",H,[o(N,{onClick:i},{default:r(()=>[_(" Cancel ")]),_:1}),o(U,{class:B(["ml-3",{"opacity-25":a(e).processing}]),disabled:a(e).processing},{default:r(()=>[_(" Save ")]),_:1},8,["class","disabled"])])])],32)]),_:1},8,["show"])],64))}};export{Z as default};
