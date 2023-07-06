import React, {useState, useCallback, useEffect} from 'react';
import {createStyles, Table, Checkbox, ScrollArea, Text, Popover, Button, Paper} from '@mantine/core';
import { Link } from '@inertiajs/inertia-react';
import { LinksTableRow } from './LinksTableRow';

const useStyles = createStyles((theme) => ({
  table: {
    "& td, & th": {
      whiteSpace: "nowrap"
    },
  },
}));

export default function LinksTable({ data }) {
  const [selection, setSelection] = useState([]);
  const [deletePopupOpened, setDeletePopupOpened] = useState(false);
  const {classes, cx} = useStyles();

  const toggleRow = (id) => {
    setSelection((current) =>
      current.includes(id) ? current.filter((item) => item !== id) : [...current, id]
    );
  };

  const toggleAll = () => {
    setSelection((current) =>
      (current.length === data.length ? [] : data.map((item) => item.id))
    );
  };

  const rows = data.map((item) => {
    return <LinksTableRow key={item.id} toggleRow={toggleRow} item={item} selected={selection.includes(item.id)} />;
  });

  return (
    <>
      <ScrollArea>
        <Table verticalSpacing="sm" className={classes.table}>
          <thead>
            <tr>
              <th>
                <Checkbox
                  onChange={toggleAll}
                  checked={selection.length === data.length}
                  indeterminate={selection.length > 0 && selection.length !== data.length}
                  transitionDuration={0}
                />
              </th>
              <th></th>
              <th>By</th>
              <th>Date</th>
              <th>Link</th>
              <th>App Url</th>
              <th>Android Url</th>
              <th>iOS Url</th>
              <th>Fallback Url</th>
              <th>Visits</th>
            </tr>
          </thead>
          <tbody>{rows}</tbody>
        </Table>
      </ScrollArea>

      {/* Delete button */}
      {selection.length ? <>
          <Text mt="xs" size='sm'>{selection.length} selected</Text>

          <Popover
            opened={deletePopupOpened}
            onClose={() => setDeletePopupOpened(false)}
            width={300}
            position="right"
            withArrow
          >
            <Popover.Target>
              <Button color="red" onClick={() => setDeletePopupOpened((o) => !o)}>Delete</Button>
            </Popover.Target>
            <Popover.Dropdown>
              <Text size="sm">Are you sure you want to delete {selection.length} links?</Text>
              <Link component={"button"} href={`/app/links/delete-batch`} data={{ids: selection}} method="delete" onSuccess={() => {
                setDeletePopupOpened(false);
                setSelection([]);
              }}>
                <Button mt={"xs"} size={"xs"} color="red">Yes!</Button>
              </Link>
            </Popover.Dropdown>
          </Popover>
        </> : null}
    </>
  );
}
