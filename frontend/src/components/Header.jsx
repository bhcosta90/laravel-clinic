"use client";
import {useState} from "react";
import Select from "@/components/Select/Index";

export const Header = () => {
    return <div>
        <div className={'flex'}>
            <input type="text" className={'input input-xs'}/>
            <Select
                apiUrl="procedures?fields=uuid name"
                onSelect={(newSelected) => {
                    console.log(newSelected)
                }}
                renderItem={(u) => <div>{u.data.name} ({u.data.name})</div>}
                labelField='data.name'
                valueField='data.uuid'
                size={'xs'}
            />
        </div>

        <div className={'flex'}>
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

        <div className={'flex'}>
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

        <div className={'flex'}>
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

        <div className={'flex'}>
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