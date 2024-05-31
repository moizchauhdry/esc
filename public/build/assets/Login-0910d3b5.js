import{h as b,i as k,j as x,u as s,o as m,f as h,k as v,v as y,c as u,w as d,a as o,X as V,t as $,g as c,b as r,l as B,d as f,n as C,e as N}from"./app-b78fbc70.js";import{_ as R}from"./GuestLayout-16c9c1b9.js";import{_ as p}from"./InputError-b345b0cc.js";import{_}from"./InputLabel-3df681eb.js";import{_ as S}from"./PrimaryButton-6c8cc1ed.js";import{_ as g}from"./TextInput-48cb22c8.js";import"./ApplicationLogo-44755756.js";const U=["value"],q={__name:"Checkbox",props:{checked:{type:[Array,Boolean],default:!1},value:{default:null}},emits:["update:checked"],setup(l,{emit:e}){const i=l,n=b({get(){return i.checked},set(t){e("update:checked",t)}});return(t,a)=>k((m(),h("input",{type:"checkbox",value:l.value,"onUpdate:modelValue":a[0]||(a[0]=w=>v(n)?n.value=w:null),class:"rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"},null,8,U)),[[x,s(n)]])}},L={key:0,class:"mb-4 font-medium text-sm text-green-600"},P=["onSubmit"],j={class:"mt-4"},D={class:"block mt-4"},E={class:"flex items-center"},F=r("span",{class:"ml-2 text-sm text-gray-600"},"Remember me",-1),M={class:"flex items-center justify-end mt-4"},J={__name:"Login",props:{canResetPassword:Boolean,status:String},setup(l){const e=y({email:"",password:"",remember:!1}),i=()=>{e.post(route("login"),{onFinish:()=>e.reset("password")})};return(n,t)=>(m(),u(R,null,{default:d(()=>[o(s(V),{title:"Log in"}),l.status?(m(),h("div",L,$(l.status),1)):c("",!0),r("form",{onSubmit:N(i,["prevent"])},[r("div",null,[o(_,{for:"email",value:"Email"}),o(g,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:s(e).email,"onUpdate:modelValue":t[0]||(t[0]=a=>s(e).email=a),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),o(p,{class:"mt-2",message:s(e).errors.email},null,8,["message"])]),r("div",j,[o(_,{for:"password",value:"Password"}),o(g,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:s(e).password,"onUpdate:modelValue":t[1]||(t[1]=a=>s(e).password=a),required:"",autocomplete:"current-password"},null,8,["modelValue"]),o(p,{class:"mt-2",message:s(e).errors.password},null,8,["message"])]),r("div",D,[r("label",E,[o(q,{name:"remember",checked:s(e).remember,"onUpdate:checked":t[2]||(t[2]=a=>s(e).remember=a)},null,8,["checked"]),F])]),r("div",M,[l.canResetPassword?(m(),u(s(B),{key:0,href:n.route("password.request"),class:"underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"},{default:d(()=>[f(" Forgot your password? ")]),_:1},8,["href"])):c("",!0),o(S,{class:C(["ml-4",{"opacity-25":s(e).processing}]),disabled:s(e).processing},{default:d(()=>[f(" Log in ")]),_:1},8,["class","disabled"])])],40,P)]),_:1}))}};export{J as default};
