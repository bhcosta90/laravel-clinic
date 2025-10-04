"use client";
import Select  from "@/components/Select/Index";

export const Header = () => {
    return <div className={'space-y-4 '}>
        <div className={'grid grid-cols-2 gap-x-2 w-full'}>
            <input type="text" className={'input input-xs w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name&order_column=name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                labelField='data.name'
                valueField='data.uuid'
                size={'xs'}
                className="w-full"
                placeholder={'Tamanho xs'}
            />
        </div>

        <div className={'grid grid-cols-2 gap-x-2 w-full'}>
            <input type="text" className={'input input-sm w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name&order_column=name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                labelField='data.name'
                valueField='data.uuid'
                size={'sm'}
                placeholder={'Tamanho sm'}
            />
        </div>

        <div className={'grid grid-cols-2 gap-x-2 w-full'}>
            <input type="text" className={'input input-md w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name&order_column=name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                labelField='data.name'
                valueField='data.uuid'
                size={'md'}
                placeholder={'Tamanho md'}
            />
        </div>

        <div className={'grid grid-cols-2 gap-x-2 w-full'}>
            <input type="text" className={'input input-lg w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name&order_column=name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                labelField='data.name'
                valueField='data.uuid'
                size={'lg'}
                placeholder={'Tamanho lg'}
            />
        </div>

        <div className={'grid grid-cols-2 gap-x-2 w-full'}>
            <input type="text" className={'input input-xl w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name&order_column=name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                labelField='data.name'
                valueField='data.uuid'
                size={'xl'}
                placeholder={'Tamanho xl'}
            />
        </div>

        <hr />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  simples'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            required
            placeholder={'Selecionar ->  com obrigatório'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            multiple
            placeholder={'Selecionar ->  com múltiplo'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            initialValues={Array.from({ length: 5 }, (_, i) => ({
                data: { uuid: `uuid-${i + 1}`, name: `Opção ${i + 1}` }
            }))}
            multiple
            placeholder={'Selecionar ->  com múltiplo com opcoes'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            multiple
            required
            placeholder={'Selecionar ->  com múltiplo e obrigatório'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            renderItem={(u) => <div className={'p-8'}>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  com renderização personalizada'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  desabilitado'}
            disabled={true}
        />

        <Select
            apiUrl="specialties?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  especialista'}
        />

        <Select
            apiUrl="procedures?fields=uuid name&order_column=name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  procedimento e adiciona o que nao existe'}
            creatable={(newSelected) => {
                console.log(newSelected)
            }}
        />

        <Select
            options={Array.from({ length: 100 }, (_, i) => ({
                data: { uuid: `uuid-${i + 1}`, name: `Opção ${i + 1}` }
            }))}
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            labelField='data.name'
            valueField='data.uuid'
            placeholder={'Selecionar ->  com opções'}
        />
    </div>
}
