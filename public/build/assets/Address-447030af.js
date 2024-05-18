import{m as f,v as x,f as b,a as n,w as m,F as V,o as C,d as p,b as e,i as a,q as S,u as o,x as d,n as U,e as w}from"./app-3daa5818.js";import{_ as A,a as $}from"./SecondaryButton-89e2c47f.js";import{_ as z}from"./PrimaryButton-e91b47a4.js";import{_ as k}from"./SuccessButton-135225c6.js";import{_ as r}from"./InputError-8cffdbba.js";const E={class:"p-6"},F=e("h2",{class:"text-lg font-medium text-gray-900"},"Shipper & Consignee Account",-1),M=e("p",{class:"mt-1 text-sm text-gray-600"}," Once your account is added, you can simply search by account number, and the address will be fetched accordingly in invoice form. ",-1),N={class:"mt-6"},B={class:"row g-2"},T={class:"col-md-4"},L=e("label",{for:""},"Type",-1),j=e("option",{value:"shipper"},"Shipper",-1),q=e("option",{value:"consignee"},"Consignee",-1),D=[j,q],O={class:"col-md-8"},P=e("label",{for:""},"Account Name",-1),Z={class:"col-md-6"},G=e("label",{for:""},"Address Line 1",-1),H={class:"col-md-6"},I=e("label",{for:""},"Address Line 2",-1),J={class:"col-md-3"},K=e("label",{for:""},"City",-1),Q={class:"col-md-3"},R=e("label",{for:""},"State",-1),W={class:"col-md-3"},X=e("label",{for:""},"Country",-1),Y={class:"col-md-3"},ee=e("label",{for:""},"Zipcode",-1),se={class:"col-md-6"},oe=e("label",{for:""},"Phone",-1),te={class:"col-md-6"},le=e("label",{for:""},"Email",-1),ne={class:"mt-6 flex justify-end"},ue={__name:"Address",setup(ae){const u=f(!1),_=f(!1),s=x({type:"",name:"",address_1:"",address_2:"",city:"",state:"",country:"",zipcode:"",phone:"",email:""}),y=()=>{u.value=!0,_.value=!1},g=()=>{s.post(route("address.create"),{preserveScroll:!0,onSuccess:c=>{console.log(c),i()},onError:c=>{console.log(c)},onFinish:()=>{}})},v=()=>{s.post(route("invoice.update"),{preserveScroll:!0,onSuccess:()=>i(),onError:()=>h(),onFinish:()=>{}})},h=()=>{},i=()=>{u.value=!1,s.reset()};return(c,t)=>(C(),b(V,null,[n(z,{onClick:y,type:"button"},{default:m(()=>[p("Add")]),_:1}),n(A,{show:u.value,onClose:i},{default:m(()=>[e("form",{onSubmit:t[10]||(t[10]=w(l=>_.value?v():g(),["prevent"]))},[e("div",E,[F,M,e("div",N,[e("div",B,[e("div",T,[L,a(e("select",{"onUpdate:modelValue":t[0]||(t[0]=l=>o(s).type=l),class:"form-control"},D,512),[[S,o(s).type]]),n(r,{message:o(s).errors.type},null,8,["message"])]),e("div",O,[P,a(e("input",{type:"text","onUpdate:modelValue":t[1]||(t[1]=l=>o(s).name=l),class:"form-control"},null,512),[[d,o(s).name]]),n(r,{message:o(s).errors.name},null,8,["message"])]),e("div",Z,[G,a(e("input",{type:"text","onUpdate:modelValue":t[2]||(t[2]=l=>o(s).address_1=l),class:"form-control"},null,512),[[d,o(s).address_1]]),n(r,{message:o(s).errors.address_1},null,8,["message"])]),e("div",H,[I,a(e("input",{type:"text","onUpdate:modelValue":t[3]||(t[3]=l=>o(s).address_2=l),class:"form-control"},null,512),[[d,o(s).address_2]]),n(r,{message:o(s).errors.address_2},null,8,["message"])]),e("div",J,[K,a(e("input",{type:"text","onUpdate:modelValue":t[4]||(t[4]=l=>o(s).city=l),class:"form-control"},null,512),[[d,o(s).city]]),n(r,{message:o(s).errors.city},null,8,["message"])]),e("div",Q,[R,a(e("input",{type:"text","onUpdate:modelValue":t[5]||(t[5]=l=>o(s).state=l),class:"form-control"},null,512),[[d,o(s).state]]),n(r,{message:o(s).errors.state},null,8,["message"])]),e("div",W,[X,a(e("input",{type:"text","onUpdate:modelValue":t[6]||(t[6]=l=>o(s).country=l),class:"form-control"},null,512),[[d,o(s).country]]),n(r,{message:o(s).errors.country},null,8,["message"])]),e("div",Y,[ee,a(e("input",{type:"text","onUpdate:modelValue":t[7]||(t[7]=l=>o(s).zipcode=l),class:"form-control"},null,512),[[d,o(s).zipcode]]),n(r,{message:o(s).errors.zipcode},null,8,["message"])]),e("div",se,[oe,a(e("input",{type:"text","onUpdate:modelValue":t[8]||(t[8]=l=>o(s).phone=l),class:"form-control"},null,512),[[d,o(s).phone]]),n(r,{message:o(s).errors.phone},null,8,["message"])]),e("div",te,[le,a(e("input",{type:"text","onUpdate:modelValue":t[9]||(t[9]=l=>o(s).email=l),class:"form-control"},null,512),[[d,o(s).email]]),n(r,{message:o(s).errors.email},null,8,["message"])])])]),e("div",ne,[n($,{onClick:i},{default:m(()=>[p(" Cancel ")]),_:1}),n(k,{class:U(["ml-3",{"opacity-25":o(s).processing}]),disabled:o(s).processing},{default:m(()=>[p(" Save ")]),_:1},8,["class","disabled"])])])],32)]),_:1},8,["show"])],64))}};export{ue as default};
