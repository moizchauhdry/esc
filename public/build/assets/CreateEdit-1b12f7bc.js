import{m as h,v as k,f as u,a as n,w as _,F as v,o as f,d as b,b as s,t as y,i,p as z,u as o,y as E,q as d,g as N,n as P,e as $}from"./app-85424c00.js";import{_ as F,a as M}from"./SecondaryButton-427d4873.js";import{_ as A}from"./PrimaryButton-2a347243.js";import{_ as B}from"./SuccessButton-e8fc0585.js";import{_ as r}from"./InputError-3f29dc8e.js";const L={class:"p-6"},j={class:"text-lg font-medium text-gray-900"},D=s("hr",null,null,-1),T={class:"mt-6"},q={class:"row g-3"},O={class:"col-md-4"},R=s("label",{for:"input21",class:"form-label"},"Role",-1),Z=["disabled"],G=s("option",{value:""},"Choose...",-1),H=["value"],I={class:"col-md-8"},J=s("label",{for:"input13",class:"form-label"},"Name",-1),K={class:"position-relative input-icon"},Q=s("span",{class:"position-absolute top-50 translate-middle-y"},[s("i",{class:"bx bx-user"})],-1),W={class:"col-md-6"},X=s("label",{for:"input15",class:"form-label"},"Phone",-1),Y={class:"position-relative input-icon"},ss=s("span",{class:"position-absolute top-50 translate-middle-y"},[s("i",{class:"bx bx-phone"})],-1),es={class:"col-md-6"},os=s("label",{for:"input16",class:"form-label"},"Email",-1),ts={class:"position-relative input-icon"},ls=s("span",{class:"position-absolute top-50 translate-middle-y"},[s("i",{class:"bx bx-envelope"})],-1),as={class:"col-md-6"},ns=s("label",{for:"input17",class:"form-label"},"Password",-1),is={class:"position-relative input-icon"},ds=s("span",{class:"position-absolute top-50 translate-middle-y"},[s("i",{class:"bx bx-lock-alt"})],-1),rs={class:"col-md-6"},cs=s("label",{for:"input17",class:"form-label"},"Confirm Password",-1),ps={class:"position-relative input-icon"},ms=s("span",{class:"position-absolute top-50 translate-middle-y"},[s("i",{class:"bx bx-lock-alt"})],-1),us={class:"col-md-6"},_s=s("label",{for:""},"Address Line 1",-1),fs={class:"col-md-6"},vs=s("label",{for:""},"Address Line 2",-1),bs={class:"col-md-3"},hs=s("label",{for:""},"City",-1),ys={class:"col-md-3"},gs=s("label",{for:""},"State",-1),xs={class:"col-md-3"},ws=s("label",{for:""},"Country",-1),Vs={class:"col-md-3"},Cs=s("label",{for:""},"Zipcode",-1),Us={class:"mt-6 flex justify-end"},Ps={__name:"CreateEdit",props:{roles:Object},setup(g,{expose:x}){const p=h(!1),c=h(!1),e=k({user_id:"",name:"",phone:"",email:"",password:"",password_confirmation:"",role:"",address_1:"",address_2:"",city:"",state:"",country:"",zipcode:""}),w=()=>{p.value=!0,c.value=!1},V=()=>{e.post(route("user.store"),{preserveScroll:!0,onSuccess:a=>{m()},onError:a=>{console.log(a)},onFinish:()=>{}})},C=a=>{console.log(a),p.value=!0,c.value=!0,e.user_id=a.id,e.role=a.role_id,e.name=a.name,e.phone=a.phone,e.email=a.email,e.address_1=a.address_1,e.address_2=a.address_2,e.city=a.city,e.state=a.state,e.country=a.country,e.zipcode=a.zipcode},U=()=>{e.post(route("user.update"),{preserveScroll:!0,onSuccess:()=>m(),onError:()=>S(),onFinish:()=>{}})},S=()=>{},m=()=>{p.value=!1,e.reset()};return x({edit:a=>C(a)}),(a,l)=>(f(),u(v,null,[n(A,{onClick:w,type:"button"},{default:_(()=>[b("Add")]),_:1}),n(F,{show:p.value,onClose:m},{default:_(()=>[s("form",{onSubmit:l[12]||(l[12]=$(t=>c.value?U():V(),["prevent"]))},[s("div",L,[s("h2",j,"User "+y(c.value?"Edit":"Create"),1),D,s("div",T,[s("div",q,[s("div",O,[R,i(s("select",{id:"input21",class:"form-select","onUpdate:modelValue":l[0]||(l[0]=t=>o(e).role=t),disabled:c.value},[G,(f(!0),u(v,null,E(g.roles,t=>(f(),u("option",{key:t.id,value:t.id},y(t.name),9,H))),128))],8,Z),[[z,o(e).role]]),n(r,{message:o(e).errors.role},null,8,["message"])]),s("div",I,[J,s("div",K,[i(s("input",{type:"text",class:"form-control",id:"input13",placeholder:"Name","onUpdate:modelValue":l[1]||(l[1]=t=>o(e).name=t)},null,512),[[d,o(e).name]]),Q]),n(r,{message:o(e).errors.name},null,8,["message"])]),s("div",W,[X,s("div",Y,[i(s("input",{type:"text",class:"form-control",id:"input15",placeholder:"Phone","onUpdate:modelValue":l[2]||(l[2]=t=>o(e).phone=t)},null,512),[[d,o(e).phone]]),ss]),n(r,{message:o(e).errors.phone},null,8,["message"])]),s("div",es,[os,s("div",ts,[i(s("input",{type:"text",class:"form-control",id:"input16",placeholder:"Email","onUpdate:modelValue":l[3]||(l[3]=t=>o(e).email=t)},null,512),[[d,o(e).email]]),ls]),n(r,{message:o(e).errors.email},null,8,["message"])]),c.value?N("",!0):(f(),u(v,{key:0},[s("div",as,[ns,s("div",is,[i(s("input",{type:"password",class:"form-control",id:"input17",placeholder:"Password","onUpdate:modelValue":l[4]||(l[4]=t=>o(e).password=t)},null,512),[[d,o(e).password]]),ds]),n(r,{message:o(e).errors.password},null,8,["message"])]),s("div",rs,[cs,s("div",ps,[i(s("input",{type:"password",class:"form-control",id:"input17",placeholder:"Password","onUpdate:modelValue":l[5]||(l[5]=t=>o(e).password_confirmation=t)},null,512),[[d,o(e).password_confirmation]]),ms])])],64)),s("div",us,[_s,i(s("input",{type:"text","onUpdate:modelValue":l[6]||(l[6]=t=>o(e).address_1=t),class:"form-control"},null,512),[[d,o(e).address_1]]),n(r,{message:o(e).errors.address_1},null,8,["message"])]),s("div",fs,[vs,i(s("input",{type:"text","onUpdate:modelValue":l[7]||(l[7]=t=>o(e).address_2=t),class:"form-control"},null,512),[[d,o(e).address_2]]),n(r,{message:o(e).errors.address_2},null,8,["message"])]),s("div",bs,[hs,i(s("input",{type:"text","onUpdate:modelValue":l[8]||(l[8]=t=>o(e).city=t),class:"form-control"},null,512),[[d,o(e).city]]),n(r,{message:o(e).errors.city},null,8,["message"])]),s("div",ys,[gs,i(s("input",{type:"text","onUpdate:modelValue":l[9]||(l[9]=t=>o(e).state=t),class:"form-control"},null,512),[[d,o(e).state]]),n(r,{message:o(e).errors.state},null,8,["message"])]),s("div",xs,[ws,i(s("input",{type:"text","onUpdate:modelValue":l[10]||(l[10]=t=>o(e).country=t),class:"form-control"},null,512),[[d,o(e).country]]),n(r,{message:o(e).errors.country},null,8,["message"])]),s("div",Vs,[Cs,i(s("input",{type:"text","onUpdate:modelValue":l[11]||(l[11]=t=>o(e).zipcode=t),class:"form-control"},null,512),[[d,o(e).zipcode]]),n(r,{message:o(e).errors.zipcode},null,8,["message"])])])]),s("div",Us,[n(M,{onClick:m},{default:_(()=>[b(" Cancel ")]),_:1}),n(B,{class:P(["ml-3",{"opacity-25":o(e).processing}]),disabled:o(e).processing},{default:_(()=>[b(" Save ")]),_:1},8,["class","disabled"])])])],32)]),_:1},8,["show"])],64))}};export{Ps as default};
