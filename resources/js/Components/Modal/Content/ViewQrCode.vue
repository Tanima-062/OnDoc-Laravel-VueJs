<template>
    <div class="border border-sky-3 rounded-[8px] max-h-[571px] overflow-y-auto self-center bg-white p-10 shadow-form">
        <div class="qrcode" style="border: 1px solid white;">
            <qrcode-vue
                :value="value"
                :size="size ?? 300"
                level="H"
                :id="`document-qrcode-${value}`"
            />

            <!-- <figure :id="`document-qrcode-${value}`" style="border: 1px solid white;">
                <qrcode-vue
                    :value="value"
                    :size="size ?? 300"
                    level="H"
                />
                <img
                    class="qrcode__image"
                    src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjEwIiBoZWlnaHQ9IjE2NSIgdmlld0JveD0iMCAwIDIxMCAxNjUiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxwYXRoIGQ9Ik0xMjcuMyAyMi4zQzEyNS45IDIyLjEgMTI0LjQgMjIgMTIyLjkgMjJIOTMuNEM4OS40IDIyIDg2LjIgMjUuMiA4Ni4yIDI5LjJWNzIuN0M2OS40IDY5LjMgNTYuOCA1NC41IDU2LjggMzYuN0M1Ni43IDE2LjUgNzMuMiAwIDkzLjUgMEMxMDguNiAwIDEyMS43IDkuMiAxMjcuMyAyMi4zWiIgZmlsbD0iIzcwNTlFMiIvPgo8cGF0aCBkPSJNMTMwLjIgMzYuN0MxMzAuMiA1NyAxMTMuNyA3My40IDkzLjUgNzMuNEM5MSA3My40IDg4LjUgNzMuMSA4Ni4yIDcyLjdWMjkuM0M4Ni4yIDI1LjMgODkuNCAyMi4xIDkzLjQgMjIuMUgxMjIuOUMxMjQuNCAyMi4xIDEyNS45IDIyLjIgMTI3LjMgMjIuNEMxMjkuMiAyNi43IDEzMC4yIDMxLjYgMTMwLjIgMzYuN1oiIGZpbGw9IiMyOTI5Q0MiLz4KPHBhdGggZD0iTTE1OS42IDU5LjFDMTU5LjQgNzkuNCAxNDIuNiA5NS42IDEyMi40IDk1LjZIOTMuNEM4OS40IDk1LjYgODYuMiA5Mi40IDg2LjIgODguNFY3Mi44Qzg4LjYgNzMuMyA5MSA3My41IDkzLjUgNzMuNUMxMTMuOCA3My41IDEzMC4yIDU3IDEzMC4yIDM2LjhDMTMwLjIgMzEuNyAxMjkuMSAyNi44IDEyNy4zIDIyLjRDMTQ1LjYgMjQuNSAxNTkuOCA0MC4yIDE1OS42IDU5LjFaIiBmaWxsPSIjNTY5RkU4Ii8+CjxwYXRoIGQ9Ik0xMTcuNiA0MC40SDk1Qzk0LjEgNDAuNCA5My40IDM5LjcgOTMuNCAzOC44VjM0LjZDOTMuNCAzMy43IDk0LjEgMzMgOTUgMzNIMTE3LjZDMTE4LjUgMzMgMTE5LjIgMzMuNyAxMTkuMiAzNC42VjM4LjhDMTE5LjIgMzkuNyAxMTguNSA0MC40IDExNy42IDQwLjRaIiBmaWxsPSJ3aGl0ZSIvPgo8cGF0aCBkPSJNMTE0LjMgNTguOEg5NC43Qzk0IDU4LjggOTMuNCA1OC4yIDkzLjQgNTcuNVY1Mi43QzkzLjQgNTIgOTQgNTEuNCA5NC43IDUxLjRIMTE0LjJDMTE0LjkgNTEuNCAxMTUuNSA1MiAxMTUuNSA1Mi43VjU3LjVDMTE1LjUgNTguMiAxMTUgNTguOCAxMTQuMyA1OC44WiIgZmlsbD0id2hpdGUiLz4KPHBhdGggZD0iTTQ2LjggMTQ5LjhDNDUuNiAxNTIuNyA0My45IDE1NS4zIDQxLjcgMTU3LjVDMzkuNSAxNTkuNyAzNyAxNjEuNCAzNCAxNjIuN0MzMSAxNjQgMjcuOCAxNjQuNiAyNC4yIDE2NC42QzIwLjYgMTY0LjYgMTcuMyAxNjQgMTQuNCAxNjIuN0MxMS40IDE2MS40IDguOSAxNTkuNyA2LjggMTU3LjVDNC43IDE1NS4zIDMgMTUyLjggMS44IDE0OS45QzAuNiAxNDcgMCAxNDMuOSAwIDE0MC42QzAgMTM3LjMgMC42IDEzNC4yIDEuOCAxMzEuM0MzIDEyOC40IDQuNyAxMjUuOCA2LjkgMTIzLjZDOS4xIDEyMS40IDExLjYgMTE5LjcgMTQuNiAxMTguNEMxNy42IDExNy4xIDIwLjggMTE2LjUgMjQuNCAxMTYuNUMyOCAxMTYuNSAzMS4zIDExNy4xIDM0LjIgMTE4LjRDMzcuMiAxMTkuNyAzOS43IDEyMS40IDQxLjggMTIzLjZDNDMuOSAxMjUuOCA0NS42IDEyOC4zIDQ2LjggMTMxLjJDNDggMTM0LjEgNDguNiAxMzcuMiA0OC42IDE0MC41QzQ4LjYgMTQzLjggNDggMTQ2LjkgNDYuOCAxNDkuOFpNMzguOCAxMzQuMkMzOCAxMzIuMiAzNi45IDEzMC40IDM1LjUgMTI4LjlDMzQuMSAxMjcuNCAzMi40IDEyNi4yIDMwLjUgMTI1LjNDMjguNSAxMjQuNCAyNi40IDEyNCAyNC4xIDEyNEMyMS44IDEyNCAxOS43IDEyNC40IDE3LjggMTI1LjNDMTUuOSAxMjYuMiAxNC4yIDEyNy4zIDEyLjggMTI4LjhDMTEuNCAxMzAuMyAxMC40IDEzMiA5LjYgMTM0LjFDOC44IDEzNi4xIDguNCAxMzguMyA4LjQgMTQwLjVDOC40IDE0Mi44IDguOCAxNDQuOSA5LjYgMTQ2LjlDMTAuNCAxNDguOSAxMS41IDE1MC43IDEyLjkgMTUyLjJDMTQuMyAxNTMuNyAxNiAxNTQuOSAxNy45IDE1NS44QzE5LjggMTU2LjcgMjIgMTU3LjEgMjQuMyAxNTcuMUMyNi42IDE1Ny4xIDI4LjcgMTU2LjcgMzAuNiAxNTUuOEMzMi41IDE1NC45IDM0LjIgMTUzLjggMzUuNiAxNTIuM0MzNyAxNTAuOCAzOCAxNDkuMSAzOC44IDE0N0MzOS42IDE0NSA0MCAxNDIuOCA0MCAxNDAuNkM0MCAxMzguNCAzOS42IDEzNi4yIDM4LjggMTM0LjJaIiBmaWxsPSIjNUQ1RDYwIi8+CjxwYXRoIGQ9Ik02MC44IDE2My44SDUyLjdWMTI4LjdINjAuOFYxMzQuMkM2MS40IDEzMy40IDYyIDEzMi42IDYyLjcgMTMxLjhDNjMuNCAxMzEuMSA2NC4yIDEzMC40IDY1LjEgMTI5LjhDNjYgMTI5LjIgNjcgMTI4LjggNjguMSAxMjguNEM2OS4yIDEyOC4xIDcwLjQgMTI3LjkgNzEuOCAxMjcuOUM3NS44IDEyNy45IDc4LjggMTI5LjEgODEgMTMxLjZDODMuMiAxMzQgODQuMiAxMzcuMyA4NC4yIDE0MS40VjE2My43SDc2LjFWMTQzLjhDNzYuMSAxNDEuMSA3NS41IDEzOC45IDc0LjIgMTM3LjVDNzIuOSAxMzYgNzEuMSAxMzUuMyA2OC43IDEzNS4zQzY2LjQgMTM1LjMgNjQuNSAxMzYuMSA2MyAxMzcuNkM2MS42IDEzOS4xIDYwLjggMTQxLjMgNjAuOCAxNDRWMTYzLjhaIiBmaWxsPSIjNUQ1RDYwIi8+CjxwYXRoIGQ9Ik0xMzEuNyAxNDkuN0MxMzAuNSAxNTIuNiAxMjguOCAxNTUgMTI2LjYgMTU3LjFDMTI0LjQgMTU5LjIgMTIxLjggMTYwLjggMTE4LjggMTYyQzExNS44IDE2My4yIDExMi40IDE2My44IDEwOC44IDE2My44SDkxLjVWMTE3LjNIMTA4LjhDMTEyLjQgMTE3LjMgMTE1LjggMTE3LjkgMTE4LjggMTE5LjFDMTIxLjggMTIwLjMgMTI0LjQgMTIxLjkgMTI2LjYgMTI0QzEyOC44IDEyNi4xIDEzMC41IDEyOC41IDEzMS43IDEzMS40QzEzMi45IDEzNC4yIDEzMy41IDEzNy4zIDEzMy41IDE0MC42QzEzMy41IDE0My44IDEzMi45IDE0Ni44IDEzMS43IDE0OS43Wk0xMjMuOCAxMzQuMkMxMjMgMTMyLjMgMTIxLjkgMTMwLjYgMTIwLjUgMTI5LjJDMTE5LjEgMTI3LjggMTE3LjQgMTI2LjcgMTE1LjQgMTI1LjlDMTEzLjQgMTI1LjEgMTExLjIgMTI0LjcgMTA4LjcgMTI0LjdIOTkuNVYxNTYuNUgxMDguN0MxMTEuMSAxNTYuNSAxMTMuNCAxNTYuMSAxMTUuNCAxNTUuM0MxMTcuNCAxNTQuNSAxMTkuMSAxNTMuNCAxMjAuNSAxNTJDMTIxLjkgMTUwLjYgMTIzIDE0OC45IDEyMy44IDE0N0MxMjQuNiAxNDUuMSAxMjUgMTQyLjkgMTI1IDE0MC42QzEyNSAxMzguMyAxMjQuNiAxMzYuMiAxMjMuOCAxMzQuMloiIGZpbGw9IiM1RDVENjAiLz4KPHBhdGggZD0iTTE3Mi44IDE1My40QzE3MS44IDE1NS42IDE3MC41IDE1Ny42IDE2OC45IDE1OS4yQzE2Ny4yIDE2MC45IDE2NS4zIDE2Mi4yIDE2MyAxNjMuMkMxNjAuNyAxNjQuMiAxNTguMiAxNjQuNyAxNTUuNSAxNjQuN0MxNTIuOCAxNjQuNyAxNTAuNCAxNjQuMiAxNDguMSAxNjMuM0MxNDUuOCAxNjIuMyAxNDMuOCAxNjEgMTQyLjIgMTU5LjRDMTQwLjUgMTU3LjcgMTM5LjIgMTU1LjggMTM4LjMgMTUzLjZDMTM3LjQgMTUxLjQgMTM2LjkgMTQ5IDEzNi45IDE0Ni41QzEzNi45IDE0NCAxMzcuNCAxNDEuNiAxMzguMyAxMzkuNEMxMzkuMyAxMzcuMiAxNDAuNiAxMzUuMiAxNDIuMiAxMzMuNkMxNDMuOSAxMzEuOSAxNDUuOCAxMzAuNiAxNDguMSAxMjkuNkMxNTAuNCAxMjguNiAxNTIuOSAxMjguMSAxNTUuNiAxMjguMUMxNTguMyAxMjguMSAxNjAuOCAxMjguNiAxNjMuMSAxMjkuNUMxNjUuNCAxMzAuNSAxNjcuNCAxMzEuOCAxNjkgMTMzLjRDMTcwLjcgMTM1LjEgMTcyIDEzNyAxNzIuOSAxMzkuMkMxNzMuOCAxNDEuNCAxNzQuMyAxNDMuOCAxNzQuMyAxNDYuM0MxNzQuMyAxNDguOCAxNzMuNyAxNTEuMiAxNzIuOCAxNTMuNFpNMTY1LjMgMTQyQzE2NC44IDE0MC42IDE2NCAxMzkuNCAxNjMuMSAxMzguNEMxNjIuMiAxMzcuNCAxNjEgMTM2LjUgMTU5LjcgMTM1LjlDMTU4LjQgMTM1LjMgMTU3IDEzNSAxNTUuNCAxMzVDMTUzLjggMTM1IDE1Mi40IDEzNS4zIDE1MS4xIDEzNS45QzE0OS44IDEzNi41IDE0OC43IDEzNy4zIDE0Ny44IDEzOC4zQzE0Ni45IDEzOS4zIDE0Ni4yIDE0MC41IDE0NS43IDE0MS45QzE0NS4yIDE0My4zIDE0NSAxNDQuNyAxNDUgMTQ2LjNDMTQ1IDE0Ny45IDE0NS4zIDE0OS4zIDE0NS44IDE1MC43QzE0Ni4zIDE1Mi4xIDE0Ny4xIDE1My4zIDE0OCAxNTQuM0MxNDguOSAxNTUuMyAxNTAuMSAxNTYuMSAxNTEuNCAxNTYuN0MxNTIuNyAxNTcuMyAxNTQuMSAxNTcuNiAxNTUuNyAxNTcuNkMxNTcuMyAxNTcuNiAxNTguOCAxNTcuMyAxNjAuMSAxNTYuN0MxNjEuNCAxNTYuMSAxNjIuNSAxNTUuMyAxNjMuNCAxNTQuM0MxNjQuMyAxNTMuMyAxNjUgMTUyLjEgMTY1LjUgMTUwLjdDMTY2IDE0OS4zIDE2Ni4yIDE0Ny45IDE2Ni4yIDE0Ni4zQzE2Ni4xIDE0NC45IDE2NS44IDE0My40IDE2NS4zIDE0MloiIGZpbGw9IiM1RDVENjAiLz4KPHBhdGggZD0iTTIwMy4zIDE2Mi44QzIwMS4xIDE2NCAxOTguMyAxNjQuNiAxOTQuOSAxNjQuNkMxOTIuMyAxNjQuNiAxODkuOSAxNjQuMSAxODcuNyAxNjMuMkMxODUuNSAxNjIuMiAxODMuNiAxNjAuOSAxODEuOSAxNTkuM0MxODAuMyAxNTcuNiAxNzkgMTU1LjcgMTc4LjEgMTUzLjVDMTc3LjIgMTUxLjMgMTc2LjcgMTQ4LjkgMTc2LjcgMTQ2LjRDMTc2LjcgMTQzLjkgMTc3LjIgMTQxLjUgMTc4LjEgMTM5LjNDMTc5IDEzNy4xIDE4MC4zIDEzNS4xIDE4MS45IDEzMy41QzE4My41IDEzMS44IDE4NS41IDEzMC41IDE4Ny43IDEyOS41QzE4OS45IDEyOC41IDE5Mi40IDEyOCAxOTUgMTI4QzE5OC4zIDEyOCAyMDEuMSAxMjguNiAyMDMuMyAxMjkuN0MyMDUuNSAxMzAuOCAyMDcuNCAxMzIuMyAyMDkgMTM0LjFMMjA0IDEzOS41QzIwMi44IDEzOC4yIDIwMS40IDEzNy4yIDIwMCAxMzYuM0MxOTguNiAxMzUuNSAxOTYuOSAxMzUuMSAxOTQuOCAxMzUuMUMxOTMuMyAxMzUuMSAxOTIgMTM1LjQgMTkwLjcgMTM2QzE4OS41IDEzNi42IDE4OC40IDEzNy40IDE4Ny41IDEzOC40QzE4Ni42IDEzOS40IDE4NS45IDE0MC42IDE4NS40IDE0MkMxODQuOSAxNDMuNCAxODQuNiAxNDQuOCAxODQuNiAxNDYuNEMxODQuNiAxNDggMTg0LjkgMTQ5LjUgMTg1LjQgMTUwLjlDMTg1LjkgMTUyLjMgMTg2LjYgMTUzLjUgMTg3LjYgMTU0LjVDMTg4LjUgMTU1LjUgMTg5LjYgMTU2LjMgMTkwLjkgMTU2LjlDMTkyLjIgMTU3LjUgMTkzLjYgMTU3LjggMTk1LjIgMTU3LjhDMTk3LjEgMTU3LjggMTk4LjggMTU3LjQgMjAwLjIgMTU2LjZDMjAxLjYgMTU1LjggMjAzIDE1NC43IDIwNC4zIDE1My40TDIwOS4yIDE1OC4yQzIwNy41IDE2MCAyMDUuNiAxNjEuNiAyMDMuMyAxNjIuOFoiIGZpbGw9IiM1RDVENjAiLz4KPC9zdmc+Cg=="
                    alt="Chen Fengyuan"
                />
            </figure> -->
        </div>
        <div class="qr__code--footer w-full flex flex-col gap-4 justify-center items-center mt-5">
            <button
                class="relative px-4 bg-violet-1 text-[#2929CC] block h-[48px] rounded-[8px] w-full cursor-pointer text-center"
                @click="print">
                {{ $t('Print QR Code') }}
            </button>
            <button
                class="frelative px-4 bg-violet-1 text-[#2929CC] block h-[48px] rounded-[8px] w-full cursor-pointer  text-center"
                @click="download">
                {{ $t('Download QR Code') }}
            </button>
        </div>
    </div>
</template>

<script setup>
import CrossIcon from "../../Icons/CrossIcon.vue";
import QrcodeVue from 'qrcode.vue'

import html2canvas from 'html2canvas'

const props = defineProps({
    value: {
        type: String,
        required: true,
    },
    size: {
        type: Number,
        required: false,
    }
});

const print = () => {
    let qrcode = document.getElementById(`document-qrcode-${props.value}`)?.toDataURL('image/png');

    const image = `<img src="${qrcode}" />`
    const w = window.open();
    w.document.body.innerHTML = image;
    setTimeout(() => {
        w.print();
        w.close();
        w.onafterprint = () => w.close();
    }, 500)

    // const docId = document.getElementById(`document-qrcode-${props.value}`)
    // html2canvas(docId).then(canvas=> {
    //     console.log(canvas)
    //     // let qrcode = document.getElementById("product-qrcode")?.toDataURL('image/png');
    //     let qrcode = canvas?.toDataURL('image/png');

    //     const image = `<img src="${qrcode}" />`
    //     const w = window.open();
    //     w.document.body.innerHTML = image;
    //     setTimeout(() => {
    //         w.print();
    //         w.close();
    //         w.onafterprint = () => w.close();
    //     }, 500)
    // })

    return;

}

const download = () => {
    var link = document.createElement('a');
    link.download = 'qrcode.png';

    link.href = document.getElementById(`document-qrcode-${props.value}`)?.toDataURL()

    link.click();

    // const docId = document.getElementById(`document-qrcode-${props.value}`)
    // html2canvas(docId).then(canvas=> {
    //     var link = document.createElement('a');
    //     link.download = 'qrcode.png';

    //     link.href = canvas?.toDataURL('image/png');;
    //     link.click();
    // })

}
</script>

<style scoped>
.qrcode {
  display: inline-block;
  font-size: 0;
  margin-bottom: 0;
  position: relative;
}

.qrcode__image {
  background-color: #fff;
  border: 0.25rem solid #fff;
  /* border-radius: 0.25rem; */
  /* box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.25); */
  height: 15%;
  left: 50%;
  overflow: hidden;
  position: absolute;
  top: 50%;
  transform: translate(-50%, -50%);
  width: 15%;
}
</style>
