import React, {useState} from 'react';
import Layout from '../../Layout';
import LinksTable from './LinksTable';
import {Head} from "@inertiajs/inertia-react";

const Links = ({links}) => {
  return (
    <>
      <Head><title>Links</title></Head>
      <LinksTable data={links}/>
    </>
  );
}

Links.layout = page => <Layout children={page} title="Links"/>

export default Links;
