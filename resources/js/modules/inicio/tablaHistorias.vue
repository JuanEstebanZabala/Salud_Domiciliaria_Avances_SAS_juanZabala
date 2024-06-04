<template>
 <button @click="oncreate=!oncreate" v-if="!oncreate" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 my-2 rounded ">
            crear Historia
        </button>  
    <div class="row" v-if="!oncreate">
       
            <div class="table-responsive">
                <dataTable :data="historias" :columns="columns" class="table table-sriped table-bordered display"
                :options="{responsive:true, autoWidth:false, dom:'Bfrtip', language:{
                    search:'Buscar', zeroRecords:'No hay registros',info:'Mostrando del _START_ a _END_ de _TOTAL_ registros',
                    infoFiltered :'(Filtrando de _MAX_ registros.)',
                    paginate:{first:'Primero', previus:'Anterior',next:'Siguiente', last:'Último'}
                }, buttons:botones}">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th  v-if="user.profile === 'Profesional'">paciente</th>
                            <th  v-if="user.profile === 'Paciente'">Profesional</th>
                            <th>Información</th>
                            <th>Hora</th>
                            <th>Fecha</th>
                            <th>Consecutivo</th>
                            <th>Estado</th>
                            <th>antecedentes</th>
                            <th>evaluación</th>
                            <th>concepto</th>
                            <th>recomendaciones</th>                           
                        </tr>
                    </thead>
                </dataTable>
            </div>        
    </div>
    <crearHistoria v-if="user.profile === 'Profesional' && oncreate" >
    </crearHistoria>

</template>
<script setup >
import DataTable from "datatables.net-vue3";
import DataTableLib from 'datatables.net-bs5';
import Buttons from 'datatables.net-buttons-bs5';
import ButtonsHtml5 from 'datatables.net-buttons/js/buttons.html5';
import print from 'datatables.net-buttons/js/buttons.print';
import pdfmake from 'pdfmake';
pdfmake.vfs=pdfFonts.pdfMake.vfs;
import pdfFonts from 'pdfmake/build/vfs_fonts'
import 'datatables.net-responsive-bs5';
import JSZip from 'jsZip';
window.JSZip = JSZip;
import { method } from 'lodash';
import { http } from '../../services/http.service';
import crearHistoria from '../crear_historia/crearHistoria.vue';
import { onBeforeMount, ref } from "vue";
import { storeToRefs } from "pinia";
import { useMenuStore } from "../menu/menu.store";
import { useAuthStore } from "../auth/auth.store";
const { historias } = storeToRefs(useMenuStore());
const { Action_get_historias } = useMenuStore();
const { user } = storeToRefs(useAuthStore());
const { Action_User } = useAuthStore();
let oncreate =ref(false);

const columns=[{data:null, render:function(data,type,row, meta)
            {return `${meta.row+1}`} },
            {data:'usuario'},
            {data:'informacion_relevante'},
            {data:'hora'},
            {data:'fecha'},
            {data:'consecutivo'},
            {data:'estado'},
            {data:'antecedentes'},
            {data:'evaluacion'},            
            {data:'concepto'},
            {data:'recomendaciones'}
        ]
const botones =[
    {title:"reporte de historias",
    extend:'excelHtml5',
    text:'Excel',
    className: 'btn btn-success'
    },
     {title:"reporte de historias",
    extend:'pdfHtml5',
    text:'PDF',
    className: 'btn btn-danger'
    },
     {title:"reporte de historias",
    extend:'print',
    text:'Imprimir',
    className: 'btn btn-dark'
    },
     {title:"reporte de historias",
    extend:'copy',
    text:'Copiar',
    className: 'btn btn-light'
    }   
    
    ]
DataTable.use(DataTableLib);
DataTable.use(pdfmake);
DataTable.use(ButtonsHtml5);

onBeforeMount(async () => {
    await Action_User();
    await Action_get_historias(user.value.profile, user.value.id)
    console.log(historias.value);
});


</script>
<style>
@import 'datatables.net-bs5'
</style>
