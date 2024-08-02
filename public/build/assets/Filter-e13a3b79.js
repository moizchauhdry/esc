import{m as $,J as C,v as A,f as l,a as r,w as c,F as d,o as i,d as _,b as o,i as f,p as v,u as a,z as y,t as h,n as E,e as O}from"./app-6b140156.js";import{_ as k,a as R}from"./SecondaryButton-17516cd7.js";import{_ as U}from"./PrimaryButton-ddd27fa5.js";import{_ as B}from"./SuccessButton-d8759e18.js";import{_ as g}from"./InputLabel-a403bda8.js";import{_ as b}from"./InputError-4469a37a.js";import"./main-dd714be5.js";import"./moment-a9aaa855.js";const D={class:"p-6"},L=o("h2",{class:"text-lg font-medium text-gray-900"},"Search Ledger",-1),P=o("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is added, you can simply search by account number, and the address will be fetched accordingly in invoice form. ",-1),z={class:"mt-6"},I={class:"row g-2"},j={class:"col-md-6"},q=["disabled"],G=o("option",{value:""},"EXPRESS SAVER CARGO",-1),T=["value"],W={class:"col-md-4"},X=["value"],Y={class:"col-md-2"},H=["value"],K={class:"mt-6 flex justify-end"},le={__name:"Filter",props:{companies:Array},setup(Q){const u=$(!1),S=$(!1),V=C().props.companies,x=C().props.ledger_company_id;var F=[{id:1,name:"January"},{id:2,name:"February"},{id:3,name:"March"},{id:4,name:"April"},{id:5,name:"May"},{id:6,name:"June"},{id:7,name:"July"},{id:8,name:"August"},{id:9,name:"September"},{id:10,name:"October"},{id:11,name:"November"},{id:12,name:"December"}],J=[{id:1,value:"2023"},{id:2,value:"2024"},{id:3,value:"2025"},{id:4,value:"2026"},{id:5,value:"2027"},{id:6,value:"2028"},{id:7,value:"2029"},{id:8,value:"2030"}],n="";const e=A({company:x||"",month:"",year:""}),M=()=>{u.value=!0,S.value=!1,n=localStorage.getItem("filters"),n&&(n=JSON.parse(n),e.company==""&&(e.company=n.company),e.month=n.month,e.year=n.year)},N=()=>{var m={company:e.company,month:e.month,year:e.year};const t=new URLSearchParams(m).toString(),s=`${route("ledger.index")}?${t}`;e.post(s,{preserveScroll:!0,onSuccess:w=>{p(),localStorage.setItem("filters",JSON.stringify(m))},onError:w=>{console.log(w)},onFinish:()=>{}})},p=()=>{u.value=!1,e.reset()};return(m,t)=>(i(),l(d,null,[r(U,{onClick:M,type:"button",class:"mx-1"},{default:c(()=>[_("Search")]),_:1}),r(k,{show:u.value,onClose:p},{default:c(()=>[o("form",{onSubmit:t[3]||(t[3]=O(s=>S.value?m.update():N(),["prevent"]))},[o("div",D,[L,P,o("div",z,[o("div",I,[o("div",j,[r(g,{for:"",value:"Company",class:"mb-1"}),f(o("select",{"onUpdate:modelValue":t[0]||(t[0]=s=>a(e).company=s),class:"form-control",disabled:a(x)},[G,(i(!0),l(d,null,y(a(V),s=>(i(),l("option",{value:s.id},h(s.name),9,T))),256))],8,q),[[v,a(e).company]]),r(b,{message:a(e).errors.company},null,8,["message"])]),o("div",W,[r(g,{for:"",value:"Month",class:"mb-1"}),f(o("select",{"onUpdate:modelValue":t[1]||(t[1]=s=>a(e).month=s),class:"form-control"},[(i(!0),l(d,null,y(a(F),s=>(i(),l("option",{value:s.id},h(s.name),9,X))),256))],512),[[v,a(e).month]]),r(b,{message:a(e).errors.company},null,8,["message"])]),o("div",Y,[r(g,{for:"",value:"Year",class:"mb-1"}),f(o("select",{"onUpdate:modelValue":t[2]||(t[2]=s=>a(e).year=s),class:"form-control"},[(i(!0),l(d,null,y(a(J),s=>(i(),l("option",{value:s.value},h(s.value),9,H))),256))],512),[[v,a(e).year]]),r(b,{message:a(e).errors.company},null,8,["message"])])])]),o("div",K,[r(R,{onClick:p},{default:c(()=>[_(" Cancel ")]),_:1}),r(B,{class:E(["ml-3",{"opacity-25":a(e).processing}]),disabled:a(e).processing},{default:c(()=>[_(" Search ")]),_:1},8,["class","disabled"])])])],32)]),_:1},8,["show"])],64))}};export{le as default};
