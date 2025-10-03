"use client";
import {useState} from "react";
import Select from "@/components/Select/Index";

export const Header = () => {
    return <div>
        <div className={'grid grid-cols-2 w-full'}>
            <input type="text" className={'input input-xs w-full'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'xs'}
                className="w-full"
            />
        </div>

        <div className={'grid grid-cols-2'}>
            <input type="text" className={'input input-sm'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'sm'}
            />
        </div>

        <div className={'grid grid-cols-2'}>
            <input type="text" className={'input input-md'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'md'}
            />
        </div>

        <div className={'grid grid-cols-2'}>
            <input type="text" className={'input input-lg'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'lg'}
            />
        </div>

        <div className={'grid grid-cols-2'}>
            <input type="text" className={'input input-xl'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'xl'}
            />
        </div>

        <Select
            apiUrl="procedures?fields=uuid name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
            multiple
        />

        <Select
            apiUrl="procedures?fields=uuid name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
            required
        />

        <Select
            apiUrl="procedures?fields=uuid name"
            onSelect={(newSelected) => {
                console.log(newSelected)
            }}
            renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
            labelField='data.name'
            valueField='data.uuid'
            multiple
            required
        />
    </div>
}